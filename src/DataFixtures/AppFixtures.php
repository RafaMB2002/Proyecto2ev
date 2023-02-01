<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Mesa;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 mesas! Bam!
        for ($i = 0; $i < 20; $i++) {
            $mesa = new Mesa();
            $mesa->setAnchura(mt_rand(10, 100));
            $mesa->setAltura(mt_rand(10, 100));
            $mesa->setX(mt_rand(10, 100));
            $mesa->setY(mt_rand(10, 100));
            $manager->persist($mesa);
        }

        $manager->flush();
    }
}
