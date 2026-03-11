<?php

namespace App\Entity\User;

use App\Entity\Traits\HasCreatedAt;
use App\Entity\Traits\HasUpdatedAt;
use App\Entity\Traits\HasUuidV7;
use App\Entity\User\User;
use App\Repository\User\UserSecurityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSecurityRepository::class)]
#[ORM\Table(name: 'us_005_user_security')]
#[ORM\HasLifecycleCallbacks]
class UserSecurity
{
    use HasUuidV7;
    use HasCreatedAt;
    use HasUpdatedAt;

    #[ORM\OneToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private int $failedLoginCount = 0;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastFailedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lockedUntil = null;

    #[ORM\Column]
    private int $emailSendCount = 0;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastEmailSentAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $passwordResetRequestedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastPasswordChangedAt = null;

    #[ORM\Column]
    private bool $isTwoFactorEnabled = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twoFactorSecret = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getFailedLoginCount(): int
    {
        return $this->failedLoginCount;
    }

    public function setFailedLoginCount(int $failedLoginCount): static
    {
        $this->failedLoginCount = $failedLoginCount;

        return $this;
    }

    public function getLastFailedAt(): ?\DateTimeImmutable
    {
        return $this->lastFailedAt;
    }

    public function setLastFailedAt(?\DateTimeImmutable $lastFailedAt): static
    {
        $this->lastFailedAt = $lastFailedAt;

        return $this;
    }

    public function getLockedUntil(): ?\DateTimeImmutable
    {
        return $this->lockedUntil;
    }

    public function setLockedUntil(?\DateTimeImmutable $lockedUntil): static
    {
        $this->lockedUntil = $lockedUntil;

        return $this;
    }

    public function getEmailSendCount(): int
    {
        return $this->emailSendCount;
    }

    public function setEmailSendCount(int $emailSendCount): static
    {
        $this->emailSendCount = $emailSendCount;

        return $this;
    }

    public function getLastEmailSentAt(): ?\DateTimeImmutable
    {
        return $this->lastEmailSentAt;
    }

    public function setLastEmailSentAt(?\DateTimeImmutable $lastEmailSentAt): static
    {
        $this->lastEmailSentAt = $lastEmailSentAt;

        return $this;
    }

    public function getPasswordResetRequestedAt(): ?\DateTimeImmutable
    {
        return $this->passwordResetRequestedAt;
    }

    public function setPasswordResetRequestedAt(?\DateTimeImmutable $passwordResetRequestedAt): static
    {
        $this->passwordResetRequestedAt = $passwordResetRequestedAt;

        return $this;
    }

    public function getLastPasswordChangedAt(): ?\DateTimeImmutable
    {
        return $this->lastPasswordChangedAt;
    }

    public function setLastPasswordChangedAt(?\DateTimeImmutable $lastPasswordChangedAt): static
    {
        $this->lastPasswordChangedAt = $lastPasswordChangedAt;

        return $this;
    }

    public function isTwoFactorEnabled(): bool
    {
        return $this->isTwoFactorEnabled;
    }

    public function setIsTwoFactorEnabled(bool $isTwoFactorEnabled): static
    {
        $this->isTwoFactorEnabled = $isTwoFactorEnabled;

        return $this;
    }

    public function getTwoFactorSecret(): ?string
    {
        return $this->twoFactorSecret;
    }

    public function setTwoFactorSecret(?string $twoFactorSecret): static
    {
        $this->twoFactorSecret = $twoFactorSecret;

        return $this;
    }
}