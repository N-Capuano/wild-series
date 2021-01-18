<?php

namespace App\DataFixtures;

use app\Entity\Actor;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
const ACTORS = [

'Andrew Lincoln',
'Norman Reedus',
'Lauren Cohan',
'Danai Gurira',

];

    public function getDependencies()  
    {
    return [ProgramFixtures::class];  
    }


    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');

        foreach (self::ACTORS as $key => $actorName)
        {
            $actor = new Actor();
            $actor->setName($actorName);
            $actor->addProgram($this->getReference('program_' . rand(1, 6)));
            $manager->persist($actor);
        };

        for ($i = 4; $i <= 54; $i++)
        {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program_' . rand(1, 6)));
            $manager->persist($actor);
        }
        $manager->flush();
    }
}
