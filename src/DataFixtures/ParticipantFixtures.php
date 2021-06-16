<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{
    const NB_PARTICIPANTS = 100;
    const NB_PROJECTS = 5;
    const ROLES = ['Project Owner', 'Volunteer'];

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < self::NB_PARTICIPANTS; $i++ ) {
            $participant = new Participant();
            $participant->setUser($this->getReference('user_' . $i));
            if ($i< self::NB_PROJECTS - 1) {
                $participant->setRole(self::ROLES[0]);
                $participant->setProject($this->getReference('project_' . $i));
            } else {
                $participant->setRole(self::ROLES[1]);
                $participant->setProject($this->getReference('project_' . rand(0,4)));
            }
            $this->addReference('participant_' . $i, $participant);
            $manager->persist($participant);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        // Lister ici toutes les classes de fixtures dont UserFixtures dépend
        return [
            UserFixtures::class,
        ];
    }
}
