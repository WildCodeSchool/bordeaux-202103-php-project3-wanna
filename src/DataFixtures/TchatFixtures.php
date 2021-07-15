<?php

namespace App\DataFixtures;

use App\Entity\Tchat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TchatFixtures extends Fixture implements DependentFixtureInterface
{
    public const TITLES = [
        'Wanna Gonna',
        'Communication community manager',
        'Webmaster site internet',
        'Je favorise l\'appropriation des technologies (téléphones-tablettes etc...) par un senior',
        'Aide juridique',
        'Campagne de communication autour du Covid',
        'Sensibilisation aux impacts du plastique',
        'Lutte contre la censure des journalistes',
        'Libération des caricatures religieuses',
        'Restaurant des monuments arméniens',
        'Protection des ours dans les pyrénees',
        'Vidéo de sensibilisation au don de moelle',
        'Accompagnement des femmes atteintes de schizophrénie',
        ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TITLES as $key => $tchatTitle) {
            $tchat = new Tchat();
            $tchat->setName($tchatTitle);
            $tchat->setProject($this->getReference('project_' . $key));
            $tchat->addUser($this->getReference('user_0'));
            $tchat->addMessage($this->getReference('tchatMessage_' . rand(0,5)));

            $manager->persist($tchat);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Lister ici toutes les classes de fixtures dont TchatFixtures dépend
        return [
            ProjectFixtures::class,
            UserFixtures::class,
            TchatMessageFixtures::class,
        ];
    }
}
