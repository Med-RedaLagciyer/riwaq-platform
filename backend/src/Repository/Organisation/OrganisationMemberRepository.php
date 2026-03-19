<?php

namespace App\Repository\Organisation;

use App\Entity\Organisation\OrganisationMember;
use App\Entity\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrganisationMember>
 */
class OrganisationMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrganisationMember::class);
    }

    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('m')
            ->join('m.organisation', 'o')
            ->addSelect('o')
            ->where('m.user = :user')
            ->setParameter('user', $user)
            ->orderBy('o.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
