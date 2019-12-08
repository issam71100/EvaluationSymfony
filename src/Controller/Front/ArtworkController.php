<?php

namespace App\Controller\Front;

use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/artworks", name="artwork.index")
     */
    public function index(ArtworkRepository $artworkRepository)
    {
        return $this->render('front/artwork/index.html.twig', [
            'artworks' => $artworkRepository->findAll()
        ]);
    }

    /**
     * @Route("/artworks/{slug}", name="artwork.category")
     */
    public function category(string $slug, ArtworkRepository $artworkRepository)
    {
        $artworks = $artworkRepository->findByCategory($slug);
        return $this->render('front/artwork/category.html.twig', [
            'artworks' => $artworks,
            'sitetitle' => $slug,
        ]);
    }

    /**
     * @Route("/artwork/{slug}", name="artwork.show")
     */
    public function show(string $slug, ArtworkRepository $artworkRepository)
    {
        $artwork = $artworkRepository->findBySlug($slug);
        if (!$artwork) {
            $this->addFlash('notice', "Cette exposition n'existe pas");
            return $this->redirectToRoute('exposition.index');
        }

        return $this->render('front/artwork/show.html.twig', [
            'artwork' => $artwork,
            'sitetitle' => $artwork->getName(),
        ]);
    }
}
