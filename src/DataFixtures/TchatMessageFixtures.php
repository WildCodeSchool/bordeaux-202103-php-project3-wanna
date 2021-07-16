<?php

namespace App\DataFixtures;

use App\Entity\TchatMessage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TchatMessageFixtures extends Fixture implements DependentFixtureInterface
{
    public const CONTENTS = [
        'Welcome',
        'Hi',
        'Happy to join this project',
        'Hope we will make it together',
        'Such a great goal to achieve together',
        'What if we call each other on a video call to introduce ourselves',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CONTENTS as $key => $contentTchat) {
            $tchatMessage = new TchatMessage();
            $tchatMessage->setContent($contentTchat);
            $tchatMessage->setSpeaker($this->getReference('user_0'));

            $manager->persist($tchatMessage);

            $this->addReference('tchatMessage_' . $key, $tchatMessage);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          UserFixtures::class,
        ];
    }
}
