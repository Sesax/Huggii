<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Message;
use App\Entity\Sujet;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SujetController extends AbstractController
{

    /**
     * @Route("/sujet/add", name="addSujet")
     */
    public function add(Request $request): Response
    {
        
        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository(Sujet::class);

        if ($request->request->get('nom')) {
            
            $nom = $request->request->get('nom');
            $description = $request->request->get('description');
            $date = new DateTime();

            $entityManager = $doctrine->getManager();

            $sujet = new Sujet();

            $sujet->setNom($nom);
            $sujet->setDescription($description);
            $sujet->setDateCreation($date);

            $entityManager->persist($sujet);

            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }

        return $this->renderForm('sujet/add.html.twig');
    }

    /**
     * @Route("/sujet/{id}", name="sujet")
     */
    public function view(Request $request, int $id): Response
    {
        $doctrine = $this->getDoctrine();

        $sujet = $doctrine->getRepository(Sujet::class)->find($id);

        if (!$sujet) {
            throw $this->createNotFoundException(
                'Aucun sujet trouvé pour cet id : '.$id
            );
        }

        $repository = $doctrine->getRepository(Message::class);

        $messages = $repository->findBy([
            'sujet' => $id
        ], ['date_creation'=>'DESC']);

        return $this->render('sujet/view.html.twig', [
            'sujet' => $sujet,
            'messages' => $messages,
        ]);
    }
}
