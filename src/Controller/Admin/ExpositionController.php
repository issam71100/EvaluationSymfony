<?php

namespace App\Controller\Admin;

use App\Entity\Exposition;
use App\Form\ExpositionType;
use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/exposition")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="admin.exposition.index", methods={"GET"})
     */
    public function index(ExpositionRepository $expositionRepository): Response
    {
        $expositions = $expositionRepository->findFutureExpositons();
        $archives = $expositionRepository->findArchiveExpositons();
        return $this->render('admin/exposition/index.html.twig', [
            'expositions' => $expositions,
            'archives' => $archives,
        ]);
    }

    /**
     * @Route("/new", name="admin.exposition.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exposition = new Exposition();
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exposition);
            $entityManager->flush();

            return $this->redirectToRoute('admin.exposition.index');
        }

        return $this->render('admin/exposition/new.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.exposition.show", methods={"GET"})
     */
    public function show(Exposition $exposition): Response
    {
        return $this->render('admin/exposition/show.html.twig', [
            'exposition' => $exposition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.exposition.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Exposition $exposition): Response
    {
        $form = $this->createForm(ExpositionType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.exposition.index');
        }

        return $this->render('admin/exposition/edit.html.twig', [
            'exposition' => $exposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.exposition.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Exposition $exposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exposition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.exposition.index');
    }
}
