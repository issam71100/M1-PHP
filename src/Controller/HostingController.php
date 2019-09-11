<?php

namespace App\Controller;

use App\Entity\Hosting;
use App\Form\HostingType;
use App\Repository\HostingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hosting")
 */
class HostingController extends AbstractController
{
    /**
     * @Route("/", name="hosting_index", methods={"GET"})
     */
    public function index(HostingRepository $hostingRepository): Response
    {
        return $this->render('hosting/index.html.twig', [
            'hostings' => $hostingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hosting_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hosting = new Hosting();
        $form = $this->createForm(HostingType::class, $hosting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hosting);
            $entityManager->flush();

            return $this->redirectToRoute('hosting_index');
        }

        return $this->render('hosting/new.html.twig', [
            'hosting' => $hosting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hosting_show", methods={"GET"})
     */
    public function show(Hosting $hosting): Response
    {
        return $this->render('hosting/show.html.twig', [
            'hosting' => $hosting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hosting_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hosting $hosting): Response
    {
        $form = $this->createForm(HostingType::class, $hosting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hosting_index');
        }

        return $this->render('hosting/edit.html.twig', [
            'hosting' => $hosting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hosting_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hosting $hosting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hosting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hosting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hosting_index');
    }
}
