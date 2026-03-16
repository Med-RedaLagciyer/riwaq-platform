<?php

namespace App\Service\Auth;

use App\Entity\User\User;
use App\Entity\User\UserSecurity;
use App\Repository\User\UserSecurityRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserSecurityService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserSecurityRepository $userSecurityRepository,
    ) {}

    public function findByUser(User $user): ?UserSecurity
    {
        return $this->userSecurityRepository->findOneBy(['user' => $user]);
    }

    public function checkEmailRateLimit(User $user): bool
    {
        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if (!$userSecurity) {
            return true;
        }

        $lastSent = $userSecurity->getLastEmailSentAt();
        $sendCount = $userSecurity->getEmailSendCount();

        if ($lastSent && $sendCount >= 3) {
            $oneHourAgo = new \DateTimeImmutable('-1 hour');
            if ($lastSent > $oneHourAgo) {
                return false;
            }
        }

        return true;
    }

    public function recordEmailSent(User $user): void
    {
        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if (!$userSecurity) {
            return;
        }

        $lastSent = $userSecurity->getLastEmailSentAt();
        $oneHourAgo = new \DateTimeImmutable('-1 hour');

        if ($lastSent && $lastSent < $oneHourAgo) {
            $userSecurity->setEmailSendCount(0);
        }

        $userSecurity->setEmailSendCount($userSecurity->getEmailSendCount() + 1);
        $userSecurity->setLastEmailSentAt(new \DateTimeImmutable());

        $this->em->flush();
    }

    public function checkPasswordResetRateLimit(User $user): bool
    {
        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if (!$userSecurity) {
            return true;
        }

        $lastReset = $userSecurity->getPasswordResetRequestedAt();

        if ($lastReset) {
            $oneHourAgo = new \DateTimeImmutable('-1 hour');
            if ($lastReset > $oneHourAgo) {
                return false;
            }
        }

        return true;
    }

    public function recordPasswordResetRequest(User $user): void
    {
        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if (!$userSecurity) {
            return;
        }

        $userSecurity->setPasswordResetRequestedAt(new \DateTimeImmutable());
        $this->em->flush();
    }

    public function recordFailedLogin(User $user): void
    {
        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if (!$userSecurity) {
            return;
        }

        $userSecurity->setFailedLoginCount($userSecurity->getFailedLoginCount() + 1);
        $userSecurity->setLastFailedAt(new \DateTimeImmutable());

        if ($userSecurity->getFailedLoginCount() >= 5) {
            $userSecurity->setLockedUntil(new \DateTimeImmutable('+15 minutes'));
        }

        $this->em->flush();
    }

    public function clearFailedLogins(User $user): void
    {
        $userSecurity = $this->userSecurityRepository->findOneBy(['user' => $user]);

        if (!$userSecurity) {
            return;
        }

        $userSecurity->setFailedLoginCount(0);
        $userSecurity->setLastFailedAt(null);
        $userSecurity->setLockedUntil(null);
        $this->em->flush();
    }
}
