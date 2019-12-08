<?php

namespace App\Controller\Front;

use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExpositionController extends AbstractController
{
    /**
     * @Route("/expositions", name="exposition.index")
     */
    public function index(ExpositionRepository $expositionRepository)
    {
        return $this->render('front/exposition/index.html.twig', [
            'expositions' => $expositionRepository->findFutureExpositons(),
        ]);
    }

    /**
     * @Route("exposition/{slug}", name="exposition.show")
     */
    public function show(string $slug, ExpositionRepository $expositionRepository)
    {
        $exposition = $expositionRepository->findBySlug($slug);
        if (!$exposition) {
            $this->addFlash('notice', "Cette exposition n'existe pas");
            return $this->redirectToRoute('exposition.index');
        }

        return $this->render('front/exposition/show.html.twig', [
            'exposition' => $exposition,
            'sitetitle' => $exposition->getName(),
        ]);
    }
}
