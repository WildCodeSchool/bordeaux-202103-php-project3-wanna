<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Project;
use App\Entity\User;
use App\Form\MessageBackType;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/messages", name="messages_")
 */
class MessageController extends AbstractController
{
    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     * @Route ("/new", name="new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $message->setSentAt(new \DateTime('now'));
            $message->setIsRead(false);
            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash("success", "Your message has correctly been sent !");
            return $this->redirectToRoute('dashboard_index', ['_fragment' => 'messages']);
        }
        return $this->render('component/message/_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param User $user
     * @param Project $project
     * @param Message $message
     * @return Response
     * @Route ("/{id}/sent/", name="sent")
     */
    public function messagesSent(User $user, Project $project, Message $message): Response
    {
        return $this->render('component/message/_messages_sent.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route ("/conv/{user}", name="conv")
     */
    public function showConv(
        MessageRepository $messageRepository,
        User $user,
        Request $request,
        EntityManagerInterface $emi
    ): Response {

        $conversations = $messageRepository->findBy([
            'receiver' => array($this->getUser(), $user),
            'sender' => array($user, $this->getUser()),
        ], ['sentAt' => 'DESC']);
        $messageBack = new Message();
        $form = $this->createForm(MessageBackType::class, $messageBack);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $messageBack->setSender($this->getUser());
            $messageBack->setReceiver($user);
            $messageBack->setSentAt(new \DateTime('now'));
            $messageBack->setIsRead(false);
            $emi->persist($messageBack);
            $emi->flush();
            return $this->redirectToRoute('messages_conv', ['user' => $user->getId()]);
        }
        return $this->render('component/message/_conversation.html.twig', [
        'conversations' => $conversations,
        'user' => $user,
        'form' => $form->createView(),
        ]);
    }
}
