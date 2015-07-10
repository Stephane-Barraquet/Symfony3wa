<?php

namespace troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use troiswa\BackBundle\Entity\Category;


class LoadCategoryData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {



        $category = new Category();
        $category->setTitle('ma super category fixtures');
        $category->setDescription('lorem ipsum');
        $category->setPosition('1');




        $manager->persist($category);
        $manager->flush();
    }
}
