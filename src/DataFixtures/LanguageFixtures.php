<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public const LANGUAGES = [
        'English',
        'French',
        'Japanese',
        'Mandarin Chinese',
        'Spanish',
        'Germanic',
        'Hindi',
        'Bengali',
        'Portuguese',
        'Russian',
        'Turkish',
        'Korean',
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
