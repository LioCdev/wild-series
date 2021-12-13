<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public const ACTORS = [
        ['Norman Reedus',
        'Andrew Lincoln',
        'Lauren Cohan',
        'Jeffrey Dean Morgan',
        'Chandler Riggs',],
        ['Bryan Cranston',
        'Aaron Paul',
        'Anna Gunn',
        'Giancarlo Esposito',
        'Dean Norris',],
    ];

    // original method
    //
    // public function load(ObjectManager $manager): void
    // {
    //     foreach (self::ACTORS as $key => $actorName) {
    //         $actor = new Actor();
    //         $actor->setName($actorName);
    //         $manager->persist($actor);
    //         $this->addReference('actor_' . $key, $actor);
    //     }
    //     $manager->flush();
    // }

    // with implode() 
    //
    public function load(ObjectManager $manager): void
    {
        foreach (self::ACTORS as $key => $actorName) {
            
            $actor = new Actor();
            $actor->setName(implode(" ", $actorName));
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }
        $manager->flush();
    }
    // loop in loop
    //
    // public function load(ObjectManager $manager): void
    // {
    //     foreach (self::ACTORS as $key => $actorNames) {
    //         foreach ($actorNames as $actorName) {
    //             $actor = new Actor();
    //             $actor->setName($actorName);
    //             $manager->persist($actor);
    //             $this->addReference('actor_' . $key, $actor);
    //         }
    //     }
    //     $manager->flush();
    // }
}
