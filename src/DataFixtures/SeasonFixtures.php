<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    /*  public const SEASONS = [
        [
            'number' => 1,
            'description' => 'saison 1',
            'year' => 2002,
            'program' => 'program_punisher'
        ],[
            'number' => 2,
            'description' => 'saison 2',
            'year' => 2003,
            'program' => 'program_punisher'

        ],[
            'number' => 3,
            'description' => 'saison 3',
            'year' => 2004, 
            'program' => 'program_punisher'

        ],
    ]; */

    /* public function load(ObjectManager $manager): void
    {
        foreach (self::SEASONS as $key => $seasons) {
            $season = new Season();
            $season->setNumber($seasons['number']);
            $season->setDescription($seasons['description']);
            $season->setYear($seasons['year']);
            $season->setProgram($this->getReference($seasons['program']));
            $manager->persist($season);
            $this->addReference('season_' . $seasons['number'], $season);
        }
        
        $manager->flush();
    } */

    protected SluggerInterface $slugger;

    public function  __construct(SluggerInterface $sluggerInterface)
    {
        $this->slugger = $sluggerInterface;
    }



    public function load(ObjectManager $manager): void
    {

        $pro = 0;
        $for = 1;
        $sea = 0;
        $faker = Factory::create();
        for ($i = 1; $i < 110; $i++) {
            $sea++;
            $season = new Season();

            if ($sea < 11) {
                $season->setNumber($sea);
            } else {
                $sea = 1;
                $season->setNumber($sea);
            }

            $season->setYear($faker->year());
            $season->setDescription($faker->paragraphs(3, true));

            $slug = $this->slugger->slug($season->getNumber());
            $season->setSlug($slug);

            $pro++;
            if ($pro < 11) {

                $season->setProgram($this->getReference('program_' . $for));
            } else {
                $for++;
                $pro = 1;
                $season->setProgram($this->getReference('program_' . $for));
            }
            $manager->persist($season);

            $this->addReference('season_' . $i, $season);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
