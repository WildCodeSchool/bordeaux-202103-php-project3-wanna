<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public const LANGUAGES = [
        'Mandarin Chinese',
        'Spanish',
        'English',
        'Germanic',
        'Hindi',
        'Bengali',
        'Portuguese',
        'Russian',
        'Japanese',
        'Turkish',
        'Korean',
        'French',
        'German',
        'Vietnamese',
        'Italian',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::LANGUAGES as $key => $languageName) {
            $language = new Language();
            $language->setName($languageName);

            $manager->persist($language);
        }

        $manager->flush();
    }
}