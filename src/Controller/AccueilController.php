<?php

namespace App\Controller;

use App\Entity\Sujet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {

        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository(Sujet::class);

        $sujets = $repository->findAll();

        return $this->render('accueil/index.html.twig', [
            'sujets' => $sujets,
        ]);
    }
}
