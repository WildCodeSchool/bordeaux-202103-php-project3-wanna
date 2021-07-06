<?php

namespace App\Controller;

use App\Entity\Tchat;
use App\Form\TchatType;
use App\Repository\TchatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tchat")
 */
class TchatController extends AbstractController
{
    /**
     * @Route("/", name="tchat_index", methods={"GET"})
     */
    public function index(TchatRepository $tchatRepository): Response
    {
        return $this->render('tchat/index.html.twig', [
            'tchats' => $tchatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tchat_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $tchat = new Tchat();
        $tchat->setName('projectTchat');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tchat);
            $entityManager->flush();

        return $this->render('component/tchat/show.html.twig', [
            'tchat' => $tchat,
        ]);
    }

    /**
     * @Route("/{id}", name="tchat_show", methods={"GET"})
     */
    public function show(Tchat $tchat): Response
    {
        return $this->render('tchat/show.html.twig', [
            'tchat' => $tchat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tchat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tchat $tchat): Response
    {
        $form = $this->createForm(TchatType::class, $tchat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tchat_index');
        }

        return $this->render('tchat/edit.html.twig', [
            'tchat' => $tchat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tchat_delete", methods={"POST"})
     */
    public function delete(Request $request, Tchat $tchat): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tchat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tchat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tchat_index');
    }
}
