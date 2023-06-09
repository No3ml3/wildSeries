<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        [
            'title' => 'Walking dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'category_Action',
        ],
        [
            'title' => 'my little poney',
            'synopsis' => 'des poneys et des arc en ciels',
            'category' => 'category_Animation',
        ],
        [
            'title' => 'harry potter',
            'synopsis' => 'Sorcier et boule de gommes',
            'category' => 'category_Fantastique',
        ],
        [
            'title' => 'ha vraiment !!',
            'synopsis' => 'mais nan c\est pas un navet français',
            'category' => 'category_Action',
        ],
        [
            'title' => 'punisher',
            'synopsis' => 'ça j\'aime bien',
            'category' => 'category_Action',
        ],
        [
            'title' => 'ça la série ',
            'synopsis' => 'boouuuuuu',
            'category' => 'category_Horreur',
        ],
        [
            'title' => 'ça l série ',
            'synopsis' => 'boouuuuuu',
            'category' => 'category_Horreur',
        ],
        [
            'title' => 'ça a série ',
            'synopsis' => 'boouuuuuu',
            'category' => 'category_Horreur',
        ],
        [
            'title' => 'ça la érie ',
            'synopsis' => 'boouuuuuu',
            'category' => 'category_Horreur',
        ],
        [
            'title' => 'ça la srie ',
            'synopsis' => 'boouuuuuu',
            'category' => 'category_Horreur',
        ], [
            'title' => 'ça la séie ',
            'synopsis' => 'boouuuuuu',
            'category' => 'category_Horreur',
        ]
    ];

    protected SluggerInterface $slugger;

    public function  __construct(SluggerInterface $sluggerInterface)
    {
        $this->slugger = $sluggerInterface;
    }

    public function load(ObjectManager $manager)
    {
        $i = 1;
        foreach (self::PROGRAMS as $key => $programe) {
            $program = new Program();
            $program->setTitle($programe['title']);
            $program->setSynopsis($programe['synopsis']);
            
            $slug = $this->slugger->slug($program->getTitle());
            $program->setSlug($slug);
            
            $program->setCategory($this->getReference($programe['category']));
            $program->setOwner($this->getReference('user_contributor1'));
            $manager->persist($program);

            $this->addReference('program_' . $i , $program);
            $i++;
        }
        
        $manager->flush(); 
    }
    

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
