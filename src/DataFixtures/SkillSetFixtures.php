<?php

namespace App\DataFixtures;

use App\Entity\SkillSet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillSetFixtures extends Fixture
{
    public const SKILLSETS = [
        'Design',
        'Video & Audio',
        'Development & IT',
        'Writing',
        'Business',
        'Engineering'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SKILLSETS as $key => $skillSetName) {
            $skillSet = new SkillSet();
            $skillSet ->setName($skillSetName);
            $manager->persist($skillSet);
            $this->addReference('skillSet_' . $skillSetName, $skillSet);
        }
        $manager->flush();
    }

}
