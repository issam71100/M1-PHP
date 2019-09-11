<?php

namespace App\Controller;

use App\Entity\Hosting;
use App\Form\HostingType;
use App\Repository\HostingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Assets\AppEncoder;

/**
 * @Route("/hosting")
 */
class HostingController extends AbstractController
{
    /**
     * @Route("/", name="hosting_index", methods={"GET"})
     * @param HostingRepository $hostingRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index(HostingRepository $hostingRepository, AppEncoder $encoder): Response
    {
        $response = $hostingRepository->findAll();
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/new", name="hosting_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder): Response
    {
        $params = $request->request->all();

        $hosting = new Hosting($params["city_id"], $params["name"], $params["address"], $params["price_per_night"], $params["type"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hosting);
            $entityManager->flush();
            $response = $encoder->encoder($hosting);
            return new Response($response, 200, ["Content-Type" => "application/json"]);

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="hosting_show", methods={"GET"})
     */
    public function show(Hosting $hosting, AppEncoder $encoder): Response
    {
        $response = $encoder->encoder($hosting);
        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/edit/{id}", name="hosting_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, Hosting $hosting, AppEncoder $encoder): Response
    {
        $params = $request->request->all();

        $entityManager = $this->getDoctrine()->getManager();
        $hosting = $entityManager->getRepository(Hosting::class)->find($id);

        if (!$hosting) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $hosting->setCity($params["city_id"]);
        $hosting->setName($params["name"]);
        $hosting->setAddress($params["address"]);
        $hosting->setPricePerNight($params["price_per_night"]);
        $hosting->setType($params["type"]);
        $entityManager->flush();

        $response = $encoder->encoder($hosting);
        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/delete/{id}", name="hosting_delete", methods={"DELETE"})
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
