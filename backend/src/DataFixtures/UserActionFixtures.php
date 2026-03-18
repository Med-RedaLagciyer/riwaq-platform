<?php

namespace App\DataFixtures;

use App\Entity\User\UserAction;
use App\Entity\User\UserPage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserActionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $pages = ['dashboard', 'organisations', 'members', 'settings', 'students', 'professors', 'staff'];

        foreach ($pages as $ref) {
            $action = new UserAction();
            $action->setPage($this->getReference('page_' . $ref, UserPage::class));
            $action->setLabel('Access');
            $action->setClassName(null);
            $action->setIdTag(null);
            $manager->persist($action);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserPageFixtures::class];
    }
}