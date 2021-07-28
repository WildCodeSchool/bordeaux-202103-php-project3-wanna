<?php

namespace App\DataFixtures;

use App\Entity\CarouselSlide;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarouselSlideFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 3; $i++) {
            $slide = new CarouselSlide();
            $slide->setNumero($i + 1);
            $slide->setTitle('Article ' . $i);
            $slide->setCaption('Lorem Ipsum ' . $i);
            $slide->setImage('https://picsum.photos/800/1200?random=' . $i);
            $manager->persist($slide);
        }
        $manager->flush();
    }
}
