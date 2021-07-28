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

        // Olivier
        $user1 = new User();
        $user1->setIsActive(true);
        $user1->setAvatar($this->getReference('avatar_1'));
        $user1->setFirstname('Olivier');
        $user1->setCountry($this->getReference('country_70'));
        $user1->setCreatedAt($now);
        $user1->setUpdatedAt($now);
        $user1->setBirthdate($now);
        $user1->setPassword('azerty');
        $user1->setRoles(self::ROLES[0]);
        $user1->setLastname('Joubert');
        $user1->setBiography('I\'m me and that\'s already hard enough !');
        $user1->setEmail('olivier@wannagonna.com');
        $manager->persist($user1);
        $this->addReference('user_1', $user1);
        $manager->flush();

                // Sara
        $user2 = new User();
        $user2->setIsActive(true);
        $user2->setAvatar($this->getReference('avatar_2'));
        $user2->setFirstname('Sara');
        $user2->setCountry($this->getReference('country_70'));
        $user2->setCreatedAt($now);
        $user2->setUpdatedAt($now);
        $user2->setBirthdate($now);
        $user2->setPassword('azerty');
        $user2->setRoles(self::ROLES[0]);
        $user2->setLastname('Ajana');
        $user2->setBiography('I\'m me and that\'s already hard enough !');
        $user2->setEmail('sara@wannagonna.com');
        $manager->persist($user2);
        $this->addReference('user_2', $user2);
        $manager->flush();

                // Killian
        $user3 = new User();
        $user3->setIsActive(true);
        $user3->setAvatar($this->getReference('avatar_3'));
        $user3->setFirstname('Killian');
        $user3->setCountry($this->getReference('country_70'));
        $user3->setCreatedAt($now);
        $user3->setUpdatedAt($now);
        $user3->setBirthdate($now);
        $user3->setPassword('azerty');
        $user3->setRoles(self::ROLES[0]);
        $user3->setLastname('Couraillon');
        $user3->setBiography('I\'m me and that\'s already hard enough !');
        $user3->setEmail('killian@wannagonna.com');
        $manager->persist($user3);
        $this->addReference('user_3', $user3);
        $manager->flush();

                // Matthieu
        $user4 = new User();
        $user4->setIsActive(true);
        $user4->setAvatar($this->getReference('avatar_4'));
        $user4->setFirstname('Matthieu');
        $user4->setCountry($this->getReference('country_70'));
        $user4->setCreatedAt($now);
        $user4->setUpdatedAt($now);
        $user4->setBirthdate($now);
        $user4->setPassword('azerty');
        $user4->setRoles(self::ROLES[0]);
        $user4->setLastname('Dejean');
        $user4->setBiography('I\'m me and that\'s already hard enough !');
        $user4->setEmail('matthieu@wannagonna.com');
        $manager->persist($user4);
        $this->addReference('user_4', $user4);
        $manager->flush();

                // Sophie
        $user5 = new User();
        $user5->setIsActive(true);
        $user5->setAvatar($this->getReference('avatar_5'));
        $user5->setFirstname('Sophie');
        $user5->setCountry($this->getReference('country_70'));
        $user5->setCreatedAt($now);
        $user5->setUpdatedAt($now);
        $user5->setBirthdate($now);
        $user5->setPassword('azerty');
        $user5->setRoles(self::ROLES[0]);
        $user5->setLastname('Wright');
        $user5->setBiography('I\'m me and that\'s already hard enough !');
        $user5->setEmail('sophie@wannagonna.com');
        $manager->persist($user5);
        $this->addReference('user_5', $user5);
        $manager->flush();

        // Admin
        $user0 = new User();
        $user0->setIsActive(true);
        $user0->setAvatar($this->getReference('avatar_0'));
        $user0->setFirstname('Admin');
        $user0->setCountry($this->getReference('country_70'));
        $user0->setCreatedAt($now);
        $user0->setUpdatedAt($now);
        $user0->setBirthdate($now);
        $user0->setPassword('azerty');
        $user0->setRoles(self::ROLES[1]);
        $user0->setLastname('Wannagonna');
        $user0->setBiography('I\'m me and that\'s already hard enough !');
        $user0->setEmail('admin@wannagonna.com');
        $manager->persist($user0);
        $this->addReference('user_0', $user0);
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
