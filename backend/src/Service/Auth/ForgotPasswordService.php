<?php

namespace App\Service\Auth;

use App\Dto\Auth\ForgotPasswordInput;
use App\Dto\Auth\ResetPasswordInput;
use App\Dto\Auth\VerifyResetCodeInput;
use App\Email\Auth\VerificationCodeEmail;
use App\Entity\User\UserToken;
use App\Enum\UserTokenType;
use App\Repository\User\UserRepository;
use App\Repository\User\UserTokenRepository;
use App\Service\Auth\UserSecurityService;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ForgotPasswordService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserRepository $userRepository,
        private UserTokenRepository $userTokenRepository,
        private JWTTokenManagerInterface $jwtManager,
        private MailerInterface $mailer,
        private UserPasswordHasherInterface $passwordHasher,
        private UserSecurityService $userSecurityService,
    ) {}

    public function sendResetCode(ForgotPasswordInput $input): array
    {
        $user = $this->userRepository->findOneBy(['email' => $input->email]);

        if (!$user || $user->getPassword() === null) {
            return ['success' => true, 'message' => 'check your email'];
        }

        if (!$this->userSecurityService->checkEmailRateLimit($user)) {
            return ['success' => false, 'message' => 'Too many attempts. Please try again later.'];
        }

        $plainCode = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $hashedCode = hash('sha256', $plainCode);

        $token = new UserToken();
        $token->setUser($user);
        $token->setType(UserTokenType::PASSWORD_RESET);
        $token->setToken($hashedCode);
        $token->setExpiresAt(new \DateTimeImmutable('+15 minutes'));

        $this->em->persist($token);
        $this->em->flush();

        $this->mailer->send(new VerificationCodeEmail($user->getEmail(), $plainCode));
        $this->userSecurityService->recordEmailSent($user);
        $this->userSecurityService->recordPasswordResetRequest($user);

        return ['success' => true, 'message' => 'check your email'];
    }

    public function verifyResetCode(VerifyResetCodeInput $input): array
    {
        $user = $this->userRepository->findOneBy(['email' => $input->email]);

        if (!$user) {
            return ['success' => false, 'message' => 'Invalid code'];
        }

        $token = $this->userTokenRepository->findLatestVerificationToken($user, UserTokenType::PASSWORD_RESET);

        if (!$token) {
            return ['success' => false, 'message' => 'Invalid code'];
        }

        if ($token->getExpiresAt() < new \DateTimeImmutable()) {
            return ['success' => false, 'message' => 'Code has expired'];
        }

        $hashedInput = hash('sha256', $input->code);

        if (!hash_equals($token->getToken(), $hashedInput)) {
            return ['success' => false, 'message' => 'Invalid code'];
        }

        $token->setUsedAt(new \DateTimeImmutable());
        $this->em->flush();

        $temporaryToken = $this->jwtManager->createFromPayload($user, [
            'scope' => 'reset_password',
            'email' => $user->getEmail(),
        ]);

        return ['success' => true, 'message' => 'code verified', 'temporary_token' => $temporaryToken];
    }

    public function resetPassword(ResetPasswordInput $input): array
    {
        $payload = $this->jwtManager->parse($input->temporaryToken);

        if (!$payload || !isset($payload['scope']) || $payload['scope'] !== 'reset_password') {
            return ['success' => false, 'message' => 'Invalid or expired token'];
        }

        $user = $this->userRepository->findOneBy(['email' => $payload['email']]);

        if (!$user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        if ($input->password !== $input->confirmPassword) {
            return ['success' => false, 'message' => 'Passwords do not match'];
        }

        $user->setPassword($this->passwordHasher->hashPassword($user, $input->password));

        $userSecurity = $this->userSecurityService->findByUser($user);
        if ($userSecurity) {
            $userSecurity->setLastPasswordChangedAt(new \DateTimeImmutable());
        }

        $this->em->flush();

        return ['success' => true, 'message' => 'Password reset successfully'];
    }
}
