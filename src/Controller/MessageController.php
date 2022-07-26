<?php

namespace App\Controller;

use \DateTime;
use App\Entity\Message;
use App\Entity\Sujet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message/add/{id}", name="messageAdd")
     */
    public function add(Request $request, int $id): Response
    {

        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository(Message::class);

        if ($request->request->get('message')) {
            
            $contenu = $request->request->get('message');
            $date = new DateTime();

            $entityManager = $doctrine->getManager();

            $message = new Message();

            $message->setContenu($contenu);
            $message->setDateCreation($date);
            $message->setSujet($doctrine->getRepository(Sujet::class)->find($id));

            $entityManager->persist($message);

            $entityManager->flush();
        }

        return $this->redirectToRoute('sujet', [
            'id' => $id,
        ]);
    }
}
