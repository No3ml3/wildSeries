<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /*  public const EPISODES = [
        [
            'title' => 'episode un',
            'number' => 1,
            'synopsis' => 'blabla voila',
            'season' => 'season_1'
        ],[
            'title' => 'episode deux',
            'number' => 2,
            'synopsis' => 'blabla voila',
            'season' => 'season_1'

        ],[
            'title' => 'episode trois',
            'number' => 3,
            'synopsis' => 'blabla voila',
            'season' => 'season_1'

        ],
    ]; */


    protected SluggerInterface $slugger;

    public function  __construct(SluggerInterface $sluggerInterface)
    {
        $this->slugger = $sluggerInterface;
    }


    public function load(ObjectManager $manager): void
    {
        /* foreach (self::EPISODES as $key => $episodes) {
            $episode = new Episode();
            $episode->setTitle($episodes['title']);
            $episode->setNumber($episodes['number']);
            $episode->setSynopsis($episodes['synopsis']);
            $episode->setSeason($this->getReference($episodes['season']));
            $manager->persist($episode);
            $this->addReference('episode_' . $key, $episode);
        }
        
        $manager->flush(); */

        $faker = Factory::create();


        $sea = 0;
        $ref = 1;
        $pro =0;
        for ($i = 1; $i < 1308; $i++) {
            $episode = new episode();
            $episode->setTitle($faker->city);

            $pro++;
            if($pro < 13){
            $episode->setNumber($pro);
            } else {
                $pro = 1;
                $episode->setNumber($pro); 
            }

            $episode->setDuration($faker->numberBetween(1, 90));
            $episode->setSynopsis($faker->paragraphs(3, true));

            $slug = $this->slugger->slug($episode->getTitle());
            $episode->setSlug($slug);

            $sea++;
            if ($sea < 13) {
                $episode->setSeason($this->getReference('season_' . $ref));
            } else {
                $ref++;
                $sea = 1;
                $episode->setSeason($this->getReference('season_' . $ref));
            }

            $manager->persist($episode);

            $this->addReference('episode_' . $i, $episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
