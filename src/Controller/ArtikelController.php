<?php

namespace App\Controller;

use App\Entity\Artikel;
use App\Form\ArtikelType;
use App\Repository\ArtikelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artikel")
 */
class ArtikelController extends AbstractController
{
    /**
     * @Route("/", name="artikel_index", methods={"GET"})
     */
    public function index(ArtikelRepository $artikelRepository): Response
    {
        return $this->render('artikel/index.html.twig', [
            'artikels' => $artikelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="artikel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artikel = new Artikel();
        $form = $this->createForm(ArtikelType::class, $artikel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artikel);
            $entityManager->flush();

            return $this->redirectToRoute('artikel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artikel/new.html.twig', [
            'artikel' => $artikel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artikel_show", methods={"GET"})
     */
    public function show(Artikel $artikel): Response
    {
        return $this->render('artikel/show.html.twig', [
            'artikel' => $artikel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artikel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artikel $artikel): Response
    {
        $form = $this->createForm(ArtikelType::class, $artikel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artikel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artikel/edit.html.twig', [
            'artikel' => $artikel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artikel_delete", methods={"POST"})
     */
    public function delete(Request $request, Artikel $artikel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artikel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artikel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artikel_index', [], Response::HTTP_SEE_OTHER);
    }
}
