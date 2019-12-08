<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MentionController extends AbstractController
{
    /**
     * @Route("/mentions-legales", name="mention.index")
     */
    public function index()
    {
        return $this->render('front/mention/index.html.twig', [
            'sitetitle' => 'Mentions légales'
        ]);
    }
}
