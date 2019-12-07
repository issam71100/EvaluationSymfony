<?php

namespace App\Controller\Front;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage.index")
     */
    public function index(ArtworkRepository $artworkRepository)
    {
        return $this->render('homepage/index.html.twig', [
            'artworks' => $artworkRepository->findAll(),
        ]);
    }
}
