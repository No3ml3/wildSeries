<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Action',
        'Aventure',
        'Animation',
        'Fantastique',
        'Horreur',
        'Enfant',
        'Arcane'
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categroyName) {
        $category = new Category();
        $category->setName($categroyName);
        $manager->persist($category);

        $this->addReference('category_' . $categroyName, $category);
        
        }
        $manager->flush();

    }

}