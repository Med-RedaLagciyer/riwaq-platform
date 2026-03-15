<?php

namespace App\Service\Auth;

use App\Dto\Auth\RegisterInput;
use App\Email\Auth\VerificationCodeEmail;
use App\Entity\User\User;
use App\Entity\User\UserProfile;
use App\Entity\User\UserSecurity;
use App\Entity\User\UserStatusLog;
use App\Entity\User\UserToken;
use App\Enum\UserTokenType;
use App\Repository\User\UserRepository;
use App\Repository\User\UserStatusRepository;
use App\Repository\User\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegisterService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserStatusRepository $userStatusRepository,
        private UserTokenRepository $userTokenRepository,
        private MailerInterface $mailer,
        private JWTTokenManagerInterface $jwtManager,
    ) {}

    public function register(RegisterInput $input): array
    {
        $existingUser = $this->userRepository->findOneBy(['email' => $input->email]);

        if ($existingUser) {
            if ($existingUser->getCurrentStatus()->getName() === 'pending_verification') {
                // generate a new code and send a new email
                $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $hashedCode = hash('sha256', $plainCode);

                $token = new UserToken();
                $token->setUser($existingUser);
                $token->setType(UserTokenType::EMAIL_VERIFICATION);
                $token->setToken($hashedCode);
                $token->setExpiresAt(new \DateTimeImmutable('+15 minutes'));

                $this->em->persist($token);
                $this->em->flush();

                $this->mailer->send(new VerificationCodeEmail($existingUser->getEmail(), $plainCode));

                return ['success' => true, 'message' => 'check your email'];
            }

            if ($existingUser->getCurrentStatus()->getName() === 'active') {
                if ($existingUser->getPassword() === null) {
                    // email verified but registration not completed
                    // send a new temporary token so they can complete registration
                    $temporaryToken = $this->jwtManager->createFromPayload($existingUser, [
                        'scope' => 'complete_registration',
                        'email' => $existingUser->getEmail(),
                    ]);

                    return ['success' => true, 'message' => 'complete_registration', 'temporary_token' => $temporaryToken];
                }

                // full account exists
                // TODO: send "you already have an account" email
                return ['success' => true, 'message' => 'account_exists'];
            }
        }

        $status = $this->userStatusRepository->findOneBy(['name' => 'pending_verification']);

        // create a new user with only email and roles in it with status pending_verification
        $user = new User();
        $user->setEmail($input->email);
        $user->setCurrentStatus($status);
        $user->setRoles(['ROLE_ORG_MANAGER']);

        // create a user security row
        $userSecurity = new UserSecurity();
        $userSecurity->setUser($user);
        $userSecurity->setEmailSendCount(1);
        $userSecurity->setLastEmailSentAt(new \DateTimeImmutable());

        // create an empty user profile
        $userProfile = new UserProfile();
        $userProfile->setUser($user);

        // generate a 6 digit code token for verification
        $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hashedCode = hash('sha256', $plainCode);

        // insert the user status log
        $statusLog = new UserStatusLog();
        $statusLog->setUser($user);
        $statusLog->setStatus($status);
        $statusLog->setNotes('Account created via registration');

        $token = new UserToken();
        $token->setUser($user);
        $token->setType(UserTokenType::EMAIL_VERIFICATION);
        $token->setToken($hashedCode);
        $token->setExpiresAt(new \DateTimeImmutable('+15 minutes'));

        $this->em->persist($user);
        $this->em->persist($userSecurity);
        $this->em->persist($userProfile);
        $this->em->persist($statusLog);
        $this->em->persist($token);
        $this->em->flush();

        // send email to the user with the code
        $this->mailer->send(new VerificationCodeEmail($input->email, $plainCode));

        return ['success' => true, 'message' => 'check your email'];
    }
}
