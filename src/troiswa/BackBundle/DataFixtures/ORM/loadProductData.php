<?php

namespace troiswa\BackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use troiswa\BackBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setTitle('mon super produit fixtures');
        $product->setDescription('lorem ipsum');
        $product->setPrice('1');
        $product->setQuantity('1');
        $product->setActive('true');



        $manager->persist($product);
        $manager->flush();
    }
}
