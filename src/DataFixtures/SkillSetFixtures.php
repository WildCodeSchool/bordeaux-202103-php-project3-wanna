<?php

namespace App\DataFixtures;

use App\Entity\SkillSet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillSetFixtures extends Fixture
{
    public const SKILLSETS = [
        'IT Development',
        'Design',
        'Traduction',
        'IT Test',
        'Research',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SKILLSETS as $key => $skillSetName) {
            $skillSet = new SkillSet();
            $skillSet ->setName($skillSetName);
            $manager->persist($skillSet);
            $this->addReference('skillSet_' . $key, $skillSet);

        }

        $manager->flush();
    }
}
