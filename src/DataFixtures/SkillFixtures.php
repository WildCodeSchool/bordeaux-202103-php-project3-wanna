<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\SkillSetFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SkillFixtures extends Fixture implements DependentFixtureInterface
{
    public const DESIGN = [
        'Logo Design',
        'Web & Mobile Design',
        'Flyer Design',
        'Brochure Design',
        'Newsletter Design',
        'Illustration',
        'Presentation Design',
        'Infographic Design',
        'Photography & Image editing',
        'Animation & motion graphics',
        'Storyboards',];

    public const VIDEO_AUDIO = [
        'Animation & Motion Graphics',
        'Video Editing',
        'Audio Editing',
        'Whiteboard & Animated Explainers',];

    public const DEVELOPMENT_IT= [
        'Wordpress',
        'Website Builder',
        'Mobile Apps',
        'Databases',
        'Desktop Application',
        'Data Analysis',
        'User Testing',];

    public const WRITING_TRANSLATION = [
        'Articles & Blog post',
        'Press Releases',
        'Research & Summaries',
        'Website content',
        'Proofreading & Editing',
        'Translation',];

    public const BUSINESS = [
        'Project Management',
        'Legal Consulting',
        'Financial Consulting',
        'Supply chain Management',];

    public const ENGINEERING_ARCHITECTURE = [
        '3D Design',
        '3D Printing',
        'Eco Conception',
        'Sustainable / Green Design Architecture',
        'Urban Designer',];



    public function load(ObjectManager $manager)
    {

    $skillset = new SkillSetFixtures();
    $skillsetnames = $skillset::SKILLSETS;

        foreach (self::DESIGN as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            $skill->setSkillSet($this->getReference('skillSet_' . $skillsetnames[0]));
            $this->addReference('skill_' . $skillName, $skill);
            $manager->persist($skill);
        }
        $manager->flush();

        foreach (self::VIDEO_AUDIO as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            $skill->setSkillSet($this->getReference('skillSet_' . $skillsetnames[1]));
            $this->addReference('skill_' . $skillName, $skill);
            $manager->persist($skill);
        }
        $manager->flush();

        foreach (self::DEVELOPMENT_IT as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            $skill->setSkillSet($this->getReference('skillSet_' . $skillsetnames[2]));
            $this->addReference('skill_' . $skillName, $skill);
            $manager->persist($skill);
        }
        $manager->flush();

        foreach (self::WRITING_TRANSLATION as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            $skill->setSkillSet($this->getReference('skillSet_' . $skillsetnames[3]));
            $this->addReference('skill_' . $skillName, $skill);
            $manager->persist($skill);
        }
        $manager->flush();

        foreach (self::BUSINESS as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            $skill->setSkillSet($this->getReference('skillSet_' . $skillsetnames[4]));
            $this->addReference('skill_' . $skillName, $skill);
            $manager->persist($skill);
        }
        $manager->flush();

        foreach (self::ENGINEERING_ARCHITECTURE as $key => $skillName) {
            $now = new \DateTime();
            $skill = new Skill();
            $skill->setName($skillName);
            $skill->setCreatedAt($now);
            $skill->setUpdatedAt($now);
            $skill->setSkillSet($this->getReference('skillSet_' . $skillsetnames[5]));
            $this->addReference('skill_' . $skillName, $skill);
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
