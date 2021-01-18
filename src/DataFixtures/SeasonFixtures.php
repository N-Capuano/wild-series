<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()  
    {
    return [ProgramFixtures::class];  
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($k = 1; $k <= 6; $k++)
        {
            for ($i = 1; $i <= 10; $i++)
            {
                $season = new Season();
                $season->setNumber($i);
                $season->setProgram($this->getReference('program_' . $k));
                $season->setYear($faker->year);
                $season->setDescription($faker->paragraph);
                $this->setReference('program_' . $k . '_season_' . $i, $season);
                $manager->persist($season);
            }
        }

        $manager->flush();
    }
}
