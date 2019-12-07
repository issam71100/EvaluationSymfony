<?php

namespace App\Controller\Admin;

use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/artwork")
 */
class ArtworkController extends AbstractController
{
    /**
     * @Route("/", name="admin.artwork.index", methods={"GET"})
     */
    public function index(ArtworkRepository $artworkRepository): Response
    {
        return $this->render('admin/artwork/index.html.twig', [
            'artworks' => $artworkRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="admin.artwork.form")
     * @Route("/update/{id}", name="admin.artwork.form.update")
     */
    public function form(Request $request, int $id = null, ArtworkRepository $artworkRepository): Response
    {
        // si l'id est nul, une insertion est exécutée, sinon une modification est exécutée
        $model = $id ? $artworkRepository->find($id) : new Artwork();
        $form = $this->createForm(ArtworkType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());

            // message de confirmation
            $message = $model->getId() ? "L'oeuvre a été modifié" : "Le produit a été ajouté";

            // message stocké en session
            $this->addFlash('notice', $message);

            /*
			 * insertion dans la base de données
			 *  - persist: méthode déclenchée uniquement lors d'une insertion
			 *  - lors d'une mise à jour, aucune méthode n'est requise
			 *  - remove: méthode déclenchée uniquement lors d'une suppression
			 *  - flush: exécution des requêtes SQL
			 */
            $entityManager = $this->getDoctrine()->getManager();
            $model->getId() ? null : $entityManager->persist($model);
            $entityManager->flush();

            // redirection
            return $this->redirectToRoute('admin.artwork.index');
        }

        return $this->render('admin/artwork/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    // /**
    //  * @Route("/new", name="admin.artwork.form", methods={"GET","POST"})
    //  */
    // public function new(Request $request): Response
    // {
    //     $artwork = new Artwork();
    //     $form = $this->createForm(ArtworkType::class, $artwork);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($artwork);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('admin.artwork.index');
    //     }

    //     return $this->render('admin/artwork/new.html.twig', [
    //         'artwork' => $artwork,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="admin.artwork.show", methods={"GET"})
     */
    public function show(Artwork $artwork): Response
    {
        return $this->render('admin/artwork/show.html.twig', [
            'artwork' => $artwork,
        ]);
    }

    // /**
    //  * @Route("/{id}/edit", name="admin.artwork.form.update", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Artwork $artwork): Response
    // {
    //     $form = $this->createForm(ArtworkType::class, $artwork);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('admin.artwork.index');
    //     }

    //     return $this->render('admin/artwork/edit.html.twig', [
    //         'artwork' => $artwork,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="admin.artwork.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artwork $artwork): Response
    {
        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artwork);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.artwork.index');
    }
}
