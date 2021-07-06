<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\SkillFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
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

    public const DESCRIPTIONS = [
        'A collaborative platform for volunteering, which brings together people skills and the needs
         of associations, organizations, communities, people, public services all around the world. Together,
          we can make a change !',        'Le but de la mission est simple : communiquer ! 
          Vous serez en effet en charge des réseaux sociaux (Facebook, Twitter, Instagram, Linkedin) 
          de l\'association mais aussi de faire vivre le site internet. Aussi, vous viendrez sur les différents
           événements (visioconférence ou présentiel selon contraintes sanitaires) prendre des photos et/ou des vidéos
            pour les publications. Vous travaillerez en équipe avec le responsable communication.',
        'Mise à jour de notre site internet, publication d’actualités. Vous savez manier Wordpress',
        'Cette mission a pour but de réduire la fracture numérique et accompagner les personnes dans leur
         appropriation des technologies numériques (appareils, applications, outils, etc.)',        'Nous recherchons
          une ou deux personnes pour nous aider avec les questions de droit sur des conventions de bénévoles ou sur 
          des contrats de bail ou sur des textes de loi.',
        'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
        'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
        'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
        'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
        'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
        'Ego vero sic intellego, Patres conscripti, nos hoc tempore in provinciis decernendis perpetuae pacis habere oportere
         rationem. Nam quis hoc non sentit omnia alia esse nobis vacua ab omni periculo atque etiam suspicione belli?',
        ];

    //0 -> Request  1 -> To start   2 -> In Progress    3-> Done    4->Archived
    public const STATUS = [
        0,
        1,
        2,
        3,
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::TITLES as $key => $projectTitle) {
            $now = new \DateTime();
            $project = new Project();
            $project->setCreatedAt($now);
            $project->setUpdatedAt($now);
            $project->setTitle($projectTitle);
            $project->setDescription(self::DESCRIPTIONS[$key]);
            $project->setStatus(rand(0, 3));
            $project->addSdg($this->getReference('sdg_' . rand(0,16)));
            $manager->persist($project);

            $this->addReference('project_' . $key, $project);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Lister ici toutes les classes de fixtures dont ProjectFixtures dépend
        return [
          SdgFixtures::class,
          SkillFixtures::class,

        ];
    }
}
