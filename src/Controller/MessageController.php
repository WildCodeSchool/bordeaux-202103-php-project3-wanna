<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Notification;
use App\Entity\Project;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @param MessageRepository $messageRepository
     * @return Response
     * @Route("/{id_project}/index", name="index")
     * @ParamConverter("project", class=Project::class, options={"mapping": {"id_project": "id"}})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        $messages = $messageRepository->findAll();
        return $this->render('message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

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

            $notificationContent =
                $this->getUser()->getFullNameIfMemberOrONG() .
                ' sent you a message !'
            ;
            $notification = new Notification($notificationContent, $message->getReceiver());
            $entityManager->persist($notification);

            $entityManager->flush();
            $this->addFlash("success", "Your message has been sent !");
            return $this->redirectToRoute('dashboard_index');
        }
        return $this->render('component/message/_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Message $message
     * @return Response
     * @Route("/notview/{not_view_id}", name="not_view", methods={"POST"})
     * @ParamConverter("message", class=Message::class, options={"mapping": {"not_view_id": "id"}})
     */
    public function notView(Message $message): Response
    {
        $message->setIsRead(false);
        $messageManager = $this->getDoctrine()->getManager();
        $messageManager->flush();
        return $this->redirectToRoute('project_show');
    }
    /**
     * @param Message $message
     * @return Response
     * @Route("/view/{view_id}", name="view", methods={"POST"})
     * @ParamConverter("message", class=Message::class, options={"mapping": {"view_id": "id"}})
     */
    public function view(Message $message): Response
    {
        $message->setIsRead(true);
        $messageManager = $this->getDoctrine()->getManager();
        $messageManager->flush();
        return $this->redirectToRoute('project_show');
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
        return $this->render('component/project/message/_messages_sent.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route ("/conv/{id}", name="conv")
     */
    public function showConv(MessageRepository $messageRepository, $id)
    {
        $conversations = $messageRepository->findBy([
            'receiver' => array($this->getUser()->getId(), $id),
            'sender' => array($id, $this->getUser()->getId()),
        ]);
        return $this->render('component/message/_conversation.html.twig', [
        'conversations' => $conversations,
        ]);
    }
}
