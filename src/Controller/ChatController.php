<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;





class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="app_chat")
     */
    public function chat(Request $request)
    {

        // Récupérer les dix derniers messages de la base de données
        $messages = $this->getDoctrine()->getRepository(Message::class)->findBy([], ['id' => 'DESC'], 10);

        // Créer un nouveau formulaire de message
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        // Traiter les données du formulaire de message envoyé
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
            $message->setSender($user);
            $message->setCreatAt(new \DateTimeImmutable());
            $message->setContent($form->getData()->getContent());

            // Enregistrer le message dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();


            // Rediriger l'utilisateur vers la page de chat
            return $this->redirectToRoute('app_chat');
        }

        // Afficher la page de chat avec les messages et le formulaire de message
        return $this->render('chat/index.html.twig', [
            'messages' => $messages,
            'form' => $form->createView(),
        ]);
    }
}
