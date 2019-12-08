<?php

namespace App\Controller\Front;

use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArtworkController extends AbstractController
{
    /**
     * @Route("/artworks", name="artwork.index")
     */
    public function index(ArtworkRepository $artworkRepository, CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAllCategoryName();
        
        return $this->render('front/artwork/index.html.twig', [
            'artworks' => $artworkRepository->findAll(),
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/artworks/{slug}", name="artwork.category")
     */
    public function category(string $slug, ArtworkRepository $artworkRepository)
    {
        $artworks = $artworkRepository->findByCategory($slug)->getResult();
        return $this->render('front/artwork/category.html.twig', [
            'artworks' => $artworks,
            'sitetitle' => $slug,
        ]);
    }

    /**
     * @Route("ajax/artworks/{slug}", name="artwork.filter")
     */
    public function filter(Request $request,string $slug, ArtworkRepository $artworkRepository, CategoryRepository $categoryRepository)
    {
        if(!$request->isXmlHttpRequest()){
			return new JsonResponse([
				'message' => 'Unauthorized'
			], JsonResponse::HTTP_FORBIDDEN);
        }

        $categories = $categoryRepository->findAllCategoryName();

        if($slug == "tous"){
            $view = $this->renderView('components/ajax_list_artwork.html.twig', [
                'artworks' => $artworkRepository->findAllArtworks()->getArrayResult(),
            ]); 
        }
        else{
            $view = $this->renderView('components/ajax_list_artwork.html.twig', [
                'artworks' => $artworkRepository->findByCategory($slug)->getArrayResult(),
            ]);
        }

        $response = [
            'view' => $view
        ];
        
        return new JsonResponse($response);
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
