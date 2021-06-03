<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\SkillSet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    public const SKILLS = [
        'Graphism',
        'Translation',
        'Application tester',
        'Redacting articles',
        'Application Development',
        'Architecture',
        'Artificial Intelligence',
        'Cloud Computing',
        'HTML',
        'C++',
        'C Language',
        'PHP',
        'UX Design',
        'Python',
        'JavaScript',
        'Java',
        'Ruby',
        'Team Building',
        'Teamwork',
        'Leadership',
        'Collaboration',
        'Written Communication',
        'Oral Communication',
        'Active Listening',
        'Communicating Complex Information in Digestible Amounts',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SKILLS as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            for ($i = 0; $i < count(SkillSetFixtures::SKILLSETS); $i++) {
                $skill->setSkillSet($this->getReference('skillSet_' . $i));
            }
            $this->addReference('skill_' . $key, $skill);
            $manager->persist($skill);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Lister ici toutes les classes de fixtures dont SkillFixtures dépend
        return [
            SkillSetFixtures::class,
        ];
    }
}
