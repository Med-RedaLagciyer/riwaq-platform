<?php

namespace App\DataFixtures;

use App\Entity\User\UserPage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserPageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Parent pages first
        $parents = [
            'dashboard' => ['label' => 'Dashboard', 'path' => '/management/dashboard', 'icon' => 'LayoutDashboard', 'order' => 1],
            'organisations' => ['label' => 'Organisations', 'path' => '/management/organisations', 'icon' => 'Building2', 'order' => 2],
            'members' => ['label' => 'Members', 'path' => null, 'icon' => 'Users', 'order' => 3],
            'settings' => ['label' => 'Settings', 'path' => '/management/settings', 'icon' => 'Settings', 'order' => 4],
        ];

        foreach ($parents as $ref => $data) {
            $page = new UserPage();
            $page->setLabel($data['label']);
            $page->setPath($data['path']);
            $page->setIcon($data['icon']);
            $page->setOrder($data['order']);
            $manager->persist($page);
            $this->addReference('page_' . $ref, $page);
        }

        // Children
        $children = [
            ['label' => 'Students', 'path' => '/management/members/students', 'icon' => 'GraduationCap', 'order' => 1, 'parent' => 'members'],
            ['label' => 'Professors', 'path' => '/management/members/professors', 'icon' => 'BookOpen', 'order' => 2, 'parent' => 'members'],
            ['label' => 'Staff', 'path' => '/management/members/staff', 'icon' => 'Briefcase', 'order' => 3, 'parent' => 'members'],
        ];

        foreach ($children as $data) {
            $page = new UserPage();
            $page->setLabel($data['label']);
            $page->setPath($data['path']);
            $page->setIcon($data['icon']);
            $page->setOrder($data['order']);
            $page->setParent($this->getReference('page_' . $data['parent'], UserPage::class));
            $manager->persist($page);
            $this->addReference('page_' . strtolower($data['label']), $page);
        }

        $manager->flush();
    }
}
