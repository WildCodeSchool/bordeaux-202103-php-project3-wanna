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
        'ROLE_USER',
        'ROLE_USER',
        'ROLE_ADMIN',
    ];

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $now = new \DateTime();
        for ($i = 0; $i < 200; $i++) {
            $user = new User();
            $user->setIsActive(true);
            $user->setAvatar($this->getReference('avatar_'  . $i));
            $user->setFirstname('firstname' . $i);
            $user->setCountry($this->getReference('country_' . $i));
            $user->setCreatedAt($now);
            $user->setUpdatedAt($now);
            $user->setPassword('test');
            $user->setRoles([]);
            $user->setLastname('lastname' . $i);
            $user->setBiography('I\'m ' . $i);
            $user->setEmail('email@gmail.com' . $i);

            $manager->persist($user);

            $this->addReference('user_' . $i, $user);
        }


        // Admin
        $user = new User();
        $plainPassword = 'azerty';
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setIsActive(true);
        $user->setFirstname('Admin');
        $user->setLastname('Admin');
        $user->setCountry($this->getReference('country_' . $i));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('admin@wannagonna.fr');
        $manager->persist($user);
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
