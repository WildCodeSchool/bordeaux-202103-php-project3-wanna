<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

    public const ROLES = [
        ['ROLE_USER'],
        ['ROLE_ADMIN'],
    ];

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $now = new \DateTime();

        // Admin
        $user0 = new User();
        $user0->setIsActive(true);
        $user0->setAvatar($this->getReference('avatar_0'));
        $user0->setFirstname('Admin');
        $user0->setCountry($this->getReference('country_70'));
        $user0->setCreatedAt($now);
        $user0->setUpdatedAt($now);
        $user0->setBirthdate($now);
        $user0->setPassword($this->encoder->encodePassword( $user0, 'wild2021'));
        $user0->setRoles(self::ROLES[1]);
        $user0->setLastname('Wannagonna');
        $user0->setBiography('I\'m the admin of Wanna Gonna');
        $user0->setEmail('admin@wannagonna.org');
        $manager->persist($user0);
        $manager->flush();
        $this->addReference('user_0', $user0);
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
