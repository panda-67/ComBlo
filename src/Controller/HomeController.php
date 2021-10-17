<?php

namespace App\Controller;

use App\Entity\Artikel;
use App\Form\ArtikelType;
use App\Repository\ArtikelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */    
    // public function index(ArtikelRepository $artikelRepository): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'artikels' => $artikelRepository->findAll(),
    //     ]);
    // }
    public function index(ArtikelRepository $artikelRepository, PaginatorInterface $paginator, Request $request): Response 
    {   
        
        $pagination = $paginator->paginate(
            $artikelRepository->findBy([], ['created_on' => 'DESC']),/* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{id}", name="artikel_view", methods={"GET"})
     */   
    public function artikelView(Artikel $artikel): Response
    {
        return $this->render('home/artikel_view.html.twig', [
            'artikel' => $artikel,
        ]);
    }
}
