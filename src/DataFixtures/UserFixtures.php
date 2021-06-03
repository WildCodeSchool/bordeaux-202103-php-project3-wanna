<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public const ROLES = [
        'ROLE_USER',
        'ROLE_USER',
        'ROLE_ADMIN',
    ];

    public function load(ObjectManager $manager)
    {
        $now = new \DateTime();
        for ($i = 0; $i < 200; $i++) {
            $user = new User();
            $user->setFirstname('firstname' . $i);
            $user->setCountry($this->getReference('country_' . $i));
            $user->setCreatedAt($now);
            $user->setUpdatedAt($now);
            $user->setPassword('test');
            $user->setRoles([]);
            $user->setLastname('lastname' . $i);
            $user->setBiography('I\'m ' . $i);
            $user->setEmail('email@gmail.com' . $i);
            $user->addSkill($this->getReference('skill_' . rand(0, 24)));
            if ($i > 180) {
                $user->addSkill($this->getReference('skill_' . rand(0, 24)));
            }
            if ($i > 190) {
                $user->addSkill($this->getReference('skill_' . rand(0, 24)));
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Lister ici toutes les classes de fixtures dont UserFixtures dépend
        return [
            CountryFixtures::class,
            SkillFixtures::class,
        ];
    }
}
