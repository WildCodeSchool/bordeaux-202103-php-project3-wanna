<?php

namespace App\DataFixtures;

use App\Entity\Avatar;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AvatarFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $src = 'DEFAULTAVATAR_sdg-wheel.png';
        for ($i = 0; $i < 1; $i++) {
            $avatar = new Avatar();
            $avatar->setName('DEFAULTAVATAR_sdg-wheel.png');
            $this->addReference('avatar_' . $i, $avatar);
            $manager->persist($avatar);
        }
        $manager->flush();
    }

}
