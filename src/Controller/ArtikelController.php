<?php

namespace App\Controller;

use App\Service\FileUploader;
use App\Entity\Artikel;
use App\Form\ArtikelType;
use App\Repository\ArtikelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

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
            'artikels' => $artikelRepository->findBy([], ['update_on' => 'DESC']),
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

            $coverFile = $form->get('cover')->getData();           
            if ($coverFile) {
                // $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);                
                // $safeFilename = $slugger->slug($originalFilename);
                $newFilename = md5(uniqid()).'.'.$coverFile->guessExtension();                
                try {
                    $coverFile->move(
                        $this->getParameter('cover_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $artikel->setCoverFilename($newFilename);
                // $coverFilename = $fileUploader->upload($coverFile);
                // $artikel->setCoverFilename($coverFilename);
            }   
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
            
            $coverFile = $form->get('cover')->getData();
            $newFilename = md5(uniqid()).'.'.$coverFile->guessExtension();
            $coverFile->move(
                $this->getParameter('cover_directory'),
                $newFilename
            );
            $artikel->setCoverFilename($newFilename);

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
