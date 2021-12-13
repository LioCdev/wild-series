<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{   

    const PROGRAMS = [
        ['title' => 'Walking Dead', 
        'synopsis' => 'Des zombies envahissent la terre',
        'country' => 'USA',
        'year' => 2010,
        'category' => 0,],
        ['title' => 'Breaking Bad', 
        'synopsis' => 'A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his family\'s future.',
        'country' => 'USA',
        'year' => 2008,
        'category' => 9,],
        ['title' => 'Narcos', 
        'synopsis' => 'A chronicled look at the criminal exploits of Colombian drug lord Pablo Escobar, as well as the many other drug kingpins who plagued the country through the years.',
        'country' => 'USA',
        'year' => 2015,
        'category' => 7,],
        ['title' => 'True Detective', 
        'synopsis' => 'Seasonal anthology series in which police investigations unearth the personal and professional secrets of those involved, both within and outside the law.',
        'country' => 'USA',
        'year' => 2014,
        'category' => 7,],
        ['title' => 'Black Mirror', 
        'synopsis' => 'Une série d\'anthologie explorant un monde tourné vers la haute technologie où se heurtent les plus grandes innovations et les instincts les plus sombres de l\'humanité.',
        'country' => 'GB',
        'year' => 2011,
        'category' => 6,],           
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $key => $programs) {
            $program = new Program();
            $slugify = new Slugify();
            $program->setTitle($programs['title']);
            $program->setSynopsis($programs['synopsis']);
            $program->setCountry($programs['country']);
            $program->setYear($programs['year']);
            $program->setCategory($this->getReference('category_'.$programs['category']));
            $program->setSlug($slugify->generate($programs['title']));
            
            //$program->setSlug($slugify->generate($program['title']));
            //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire
            //for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            //    $program->addActor($this->getReference('actor_' . $i));
            foreach (ActorFixtures::ACTORS as $ref => $actors){
                foreach ($actors as $actor){
                    $program->addActor($this->getReference('actor_' .$key));
                }
            }
            $manager->persist($program);
            $manager->flush();
        }
    }
    // public function load(ObjectManager $manager)
    // {
    //     foreach (self::PROGRAMS as $key => $programsTitle) {
    //         $program = new Program();
    //         $program->setTitle($programsTitle);
    //         $program->setSynopsis('Des zombies envahissent la terre');
    //         $program->setCountry('USA');
    //         $program->setYear(2009);
    //         $program->setCategory($this->getReference('category_0'));
    //         //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire
    //         for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
    //             $program->addActor($this->getReference('actor_' . $i));
    //         }
    //         $manager->persist($program);
    //         $manager->flush();
    //     }
    // }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
          ActorFixtures::class,
          CategoryFixtures::class,
        ];
    }


}
