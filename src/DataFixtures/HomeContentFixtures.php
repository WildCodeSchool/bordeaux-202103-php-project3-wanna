<?php

namespace App\DataFixtures;

use App\Entity\HomeContent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HomeContentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $homeContent = new HomeContent();
        $homeContent->setIntroTitle('WANNA GONNA');
        $homeContent->setIntroContent('A collaborative platform for volunteering, which brings together people skills and the needs of associations, organizations, communities, people, public services all around the world. Together, we can make a change ! ');
        $homeContent->setSection1Title('Concept');
        $homeContent->setSection1Content('Quanta autem vis amicitiae sit, ex hoc intellegi maxime potest, quod ex infinita societate generis humani, quam conciliavit ipsa natura, ita contracta res est et adducta in angustum ut omnis caritas aut inter duos aut inter paucos iungeretur. ');
        $homeContent->setSection2Title('Who we are ?');
        $homeContent->setSection2Content('Procedente igitur mox tempore cum adventicium nihil inveniretur, relicta ora maritima in Lycaoniam adnexam Isauriae se contulerunt ibique densis intersaepientes itinera praetenturis provincialium et viatorum opibus pascebantur. ');
        $homeContent->setSection3Title('How does it work ?');
        $homeContent->setSection3Intro('Quanta autem vis amicitiae sit, ex hoc intellegi maxime potest, quod ex infinita societate generis humani, quam conciliavit ipsa natura, ita contracta res est et adducta in angustum ut omnis caritas aut inter duos aut inter paucos iungeretur. ');
        $homeContent->setSection3Video1('https://www.youtube.com/embed/hWtdpxxVy2A');
        $homeContent->setSection3Video1Content('Procedente igitur mox tempore cum adventicium nihil inveniretur, relicta ora maritima in Lycaoniam adnexam Isauriae se contulerunt ibique densis intersaepientes itinera praetenturis provincialium et viatorum opibus pascebantur. ');
        $homeContent->setSection3Video2('https://www.youtube.com/embed/hWtdpxxVy2A');
        $homeContent->setSection3Video2Content('Procedente igitur mox tempore cum adventicium nihil inveniretur, relicta ora maritima in Lycaoniam adnexam Isauriae se contulerunt ibique densis intersaepientes itinera praetenturis provincialium et viatorum opibus pascebantur. ');
        $manager->persist($homeContent);
        $manager->flush();
    }
}
