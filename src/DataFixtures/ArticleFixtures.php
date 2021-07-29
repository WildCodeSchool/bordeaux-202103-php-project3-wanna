<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public const TITLES = [
        'Une réduction d’impôt pour inciter les Français à faire du bénévolat ?',
        'What\'s It Like To Volunteer For A Good Cause? These Lecturers Share Their Experience',
        'EU Leaders Confront Hungary’s Leadership Over New Anti-LGBT Law',
    ];

    public const DESCRIPTIONS = [
        'Le député Les Républicains Ian Boucard a déposé, en ce mois de juin, une proposition de loi à l’Assemblée nationale qui vise à créer une réduction d\’impôt sur le revenu (IR) pour les bénévoles qui s\’investissent dans une association. Interview.',
        'Based on a 2012 report by MATEC Web of Conferences, it was revealed that only seven out of 1,000 Malaysians are volunteers. While there are no recent numbers to indicate whether there has been a significant increase, studies and reports over the years have shown that the country still lacks volunteers. 
         Instead of volunteering, it has been reported that Malaysians have mostly contributed to society through monetary and in-kind donations. Although it\'s a good gesture, numerous NGOs have expressed their wish for Malaysians to go the extra mile by volunteering, especially among the youths.',
         'On June 24th, European Union leaders confronted Prime Minister Viktor Orban over Hungary\’s new anti-LGBTQ law, stressing their commitment to defending all human rights. According to Reuters, the bill bans the distribution of the material in schools that promotes homosexuality or gender change and was approved last week by Hungary\’s parliament. Leaders from across the world, as well as multiple human rights groups, have put pressure on Budapest to step back in this question and urge the Prime Minister to have it revoked. A letter signed by the leaders of Germany and France stated: We must continue fighting against discrimination of the LGBTQ community, reaffirming our defense of their fundamental rights, Reuter reports.  
        Arriving at the meeting in Brussel with the 27 leaders from each EU member state, Orban stated: The law is already announced, it\’s published, it\’s done, from which he received major resistance from the EU leaders. European Commission President Ursula von der Leyen described the bill as shameful and explained how the bloc\’s executive would take action and not compromise on principles such as human dignity, equality, and respect for human rights. Additionally, Germany, the Netherlands, Sweden, France, Ireland to name a few, have given Hungary massive criticism over the law. A Swedish minister described it as “grotesque,” according to Reuters. Dutch Prime Minister Mark Rutte declared his point of view with this statement: “It is my intention, on this point, to bring Hungary to its knees. They have to realize they are either a member of the European Union and so a member of the community of shared values that we are… or get out.” Similarly, Ireland\’s Thomas Byrne explained his concerns by passing the bill and how it might affect the democracy of Hungary, as well as its relationship with the EU. 
        Multiple landmarks and other iconic places such as Brussel’s Grand Place square and the European Parliament were adorned with LGBTQ flags or lit up in rainbow colors on Thursday to oppose the bill. It is critical for the EU and its leaders to take a stand and not tolerate discriminative laws to be approved by any of its members. However, later the same day of June 24th, Germany\’s Euro 2020 match against Hungary at Munich soccer stadium was denied to be illuminated in rainbow colors, which is a symbol of gay pride. The decision angered many and sparked protests and criticism from various human rights groups across the world. According to Reuters, European politicians found it “very irritating” that UEFA had an issue with the colors of the rainbow. Essentially, it is necessary for the EU to take a stand against discriminatory bills that do not align with the EU’s mission of promoting LGBTQ rights. UEFA’s decision to not engage with the political side of each nation is ultimately problematic, as it portrays a decision to not side with the fundamental rights that the EU stands for. 
        The EU has had issues with Hungary undermining the rule of law for a long time and has consequently launched a formal legal investigation of Orban\’s government. Orban has been in power since 2010 and has a large parliamentary majority, but with the election coming up next year he has been increasingly combative on social issues. The clash between the EU and the Hungarian government is only one of the multiple confrontations bloc has had with Orban on issues ranging from his treatment of refugees and migrants to pressure on academics and media. Although the leader denies undermining Hungarian democracy, there is evidence of the government using EU funds to build a loyal business elite while constraining the independence of the media, non-governmental organizations, and universities. As a defense of the latest bill, Orban explained it was aimed at giving parents the exclusive right to decide about their children’s sexual education. However, as a consequence of the latest legislations by Orban, the EU has now developed new tools to cut handouts from the bloc for states disregarding democratic values.
        Conclusively, the European Commission will take action against Hungary over the new restrictions on LGBT rights, as the head of the bloc’s executive announced they violated fundamental EU values. Von der Leyen, President of the EU Commission, said the LGBTQ bill clearly contradicted the very values on which the European Union was founded. She continued to emphasize how she will continue to promote European Union where you are free to love whom you want and advocates diversity. Her speech on this is the foundation of the values of the EU, was greeted by applause and support from the member states. It is essential to use all the powers of the Commission to ensure that the rights of all EU citizens are guaranteed, whoever you are and wherever you live.',
    ];

    public const IMAGES = [
        'https://www.studyrama.com/local/cache-vignettes/L990xH363/arton106396-d9d99.png?1607625956',
        'https://images.says.com/uploads/story_source/source_image/910910/8e50.jpg',
        'https://theowp.org/wp-content/uploads/2021/06/GettyImages-1221664974-1160x822-1-800x567.jpeg',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TITLES as $key => $articleTitle) {
            $now = new \DateTime();
            $article = new Article();
            $article->setCreatedAt($now);
            $article->setUpdatedAt($now);
            $article->setTitle($articleTitle);
            $article->setUser($this->getReference('user_0'));
            $article->setContent(self::DESCRIPTIONS[$key]);
            $article->setImage(self::IMAGES[$key]);

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
