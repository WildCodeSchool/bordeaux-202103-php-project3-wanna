<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public const TITLES = [
        'Secrétariat',
        'Comptabilité',
        'Informatique',
        'Communication',
        'Formation',
    ];

    public const DESCRIPTIONS = [
        'Accueil téléphonique : permanence téléphonique 7/7 jours et 24/24 heures. Lors d\'un appel, soyez aimables et donnez les informations correctes, noter les informations du contact et dirigez-le vers le service adéquat',
        'Répertorier tous les mouvements de flux, les dépenses et les recettes de l\’association. Bien comprendre le fonctionnement et les enjeux. Communiquer le résultat au résponsable de l\'association toutes les fins de mois',
        'Créer le site vitrine de l\'association, ce site web doit résumer à la présentation de l\'organisation etc. Il s\'oppose au site marchand ou à la boutique en ligne qui offrent, de leur côté, la possibilité de réaliser des transactions en ligne.',
        'fiches, flyers, kakemono, e-mailings, site, lettre d\'info, réseaux et médias sociaux, relations presse et influenceurs... vous disposez aujourd\'hui d\'un éventail de canaux Print et Web pour bien communiquer sur le projet associatif',
        'Dispensez des formations à distance sous forme de webinaires, structurée par calendrier et thématiques. Gestion en demi-groupes et espace de la classe repensé, développement de la coopération, de l\’entraide et validation entre pairs',
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 5; $i++) {
            foreach (self::TITLES as $key => $taskTitle) {
                $now = new \DateTime();
                $task = new Task();
                $task->setCreatedAt($now);
                $task->setUpdatedAt($now);
                $task->setName($taskTitle);
                $task->setDescription(self::DESCRIPTIONS[$key]);
                $task->setProject($this->getReference('project_' . rand(0, 4)));
                $task->setStatus(rand(0, 2));
                $task->addUser($this->getReference('user_' . rand(0, 199)));

                $manager->persist($task);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProjectFixtures::class,
            UserFixtures::class,
        ];
    }
}
