<?php

namespace App\Entity\User;

use App\Entity\Traits\HasCreatedAt;
use App\Entity\Traits\HasUuidV7;
use App\Entity\User\User;
use App\Repository\User\UserLoginLogRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserLoginLogRepository::class)]
#[ORM\Table(name: 'us_004_user_login_log')]
#[ORM\HasLifecycleCallbacks]
class UserLoginLog
{
    use HasUuidV7;
    use HasCreatedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 45)]
    private ?string $ipAddress = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $userAgent = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $deviceType = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $browser = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $os = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $city = null;

    #[ORM\Column]
    private bool $isSuspicious = false;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(?string $userAgent): static
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(?string $deviceType): static
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function setBrowser(?string $browser): static
    {
        $this->browser = $browser;

        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(?string $os): static
    {
        $this->os = $os;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function isSuspicious(): bool
    {
        return $this->isSuspicious;
    }

    public function setIsSuspicious(bool $isSuspicious): static
    {
        $this->isSuspicious = $isSuspicious;

        return $this;
    }
}