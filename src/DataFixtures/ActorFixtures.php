<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    protected SluggerInterface $slugger;

    public function  __construct(SluggerInterface $sluggerInterface)
    {
        $this->slugger = $sluggerInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i < 10; $i++) {
            $actor = new Actor();
            $actor->setName($faker->firstName);

            $slug = $this->slugger->slug($actor->getName());
            $actor->setSlug($slug);

            $program1 = $this->getReference('program_'. $faker->numberBetween(1, 11));
            $program2 = $this->getReference('program_' . $faker->numberBetween(1, 11));
            $program3 = $this->getReference('program_' . $faker->numberBetween(1, 11));
            $actor->addProgram($program1);
            $actor->addProgram($program2);
            $actor->addProgram($program3);

            $manager->persist($actor);

            $this->addReference('actor_' . $i, $actor);
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
