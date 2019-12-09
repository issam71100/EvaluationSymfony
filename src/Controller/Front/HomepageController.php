<?php

namespace App\Controller\Front;

use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage.index")
     */
    public function index(ArtworkRepository $artworkRepository, CategoryRepository $categoryRepository)
    {
        $categoryNames = $categoryRepository->findAllCategoryName();

        foreach ($categoryNames as $key => $category){
            //commandes
            $artworks[$category['slug']] = $artworkRepository->findByCategoryLimited($category['slug'], 3);
        }


        return $this->render('front/homepage/index.html.twig', [
            'artworks' => $artworks,
            'categories_names' => $categoryNames
        ]);
    }
}
