<?php

namespace App\DataFixtures;

use App\Entity\Sdg;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SdgFixtures extends Fixture
{
    public const SDGS = [
        'NO POVERTY',
        'ZERO HUNGER',
        'GOOD HEALTH AND WELL-BEING',
        'QUALITY EDUCATION',
        'GENDER EQUALITY',
        'CLEAN WATER AND SANITATION',
        'AFFORDABLE AND CLEAN ENERGY',
        'DECENT WORK AND ECONOMIC GROWTH',
        'INDUSTRY, INNOVATION, AND INFRASTRUCTURE',
        'REDUCED INEQUALITIES',
        'SUSTAINABLE CITIES AND COMMUNITIES',
        'RESPONSIBLE CONSUMPTION AND PRODUCTION',
        'CLIMATE ACTION',
        'LIFE BELOW WATER',
        'LIFE ON LAND',
        'PEACE, JUSTICE AND STRONG INSTITUTIONS',
        'PARTNERSHIPS',
    ];

    public const DESCRIPTIONS = [
        'Economic growth must be inclusive to provide sustainable jobs and promote equality.',
        'The food and agriculture sector offers key solutions for development, and is central for
         hunger and poverty eradication.',        'Ensuring healthy lives and promoting the well-being for all 
         at all ages is essential to sustainable development.',
        'Obtaining a quality education is the foundation to improving people’s lives and sustainable development.',
        'Gender equality is not only a fundamental human right, but a necessary foundation for a peaceful, prosperous
         and sustainable world.',
        'Clean, accessible water for all is an essential part of the world we want to live in.',
        'Energy is central to nearly every major challenge and opportunity.',
        'Sustainable economic growth will require societies to create the conditions that allow people to have quality
         jobs.',
        'Investments in infrastructure are crucial to achieving sustainable development.',
        'To reduce inequalities, policies should be universal in principle, paying attention to the needs of 
        disadvantaged and marginalized populations.',
        'There needs to be a future in which cities provide opportunities for all, with access to basic services,
         energy, housing, transportation and more.',
        'Responsible Production and Consumption',
        'Climate change is a global challenge that affects everyone, everywhere.',
        'Careful management of this essential global resource is a key feature of a sustainable future.',
        'Sustainably manage forests, combat desertification, halt and reverse land degradation, halt biodiversity loss',
        'Access to justice for all, and building effective, accountable institutions at all levels.',
        'Revitalize the global partnership for sustainable development.',
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::SDGS as $key => $SDGName) {
            $sdg = new Sdg();
            $sdg->setName($SDGName);
            $sdg->setDescription(self::DESCRIPTIONS[$key]);
            $sdg->setIdentifier('GOAL ' . $key);
            $this->addReference('sdg_' . $key, $sdg);

            $manager->persist($sdg);
        }

        $manager->flush();
    }
}
