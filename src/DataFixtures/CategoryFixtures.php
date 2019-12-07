<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$categoryNames = ['Peinture', 'Dessin', 'Sculpture'];
		 
    	for($i = 0; $i < sizeof($categoryNames); $i++){
		    $category = new Category();
		    $category->setName($categoryNames[$i]);
			$category->setSlug($categoryNames[$i]);

			// créer une référence pour mettre en relation les entités : mise en mémoire de l'instance
			$this->addReference("category$i", $category);
		    $manager->persist($category);
	    }

        $manager->flush();
    }
}
