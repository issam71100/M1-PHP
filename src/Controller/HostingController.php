<?php

namespace App\Controller;

use App\Entity\Hosting;
use App\Form\HostingType;
use App\Repository\HostingRepository;
use App\Repository\CityRepository;
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
     * @param CityRepository $cityRepository
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder, CityRepository $cityRepository): Response
    {
        $params = $request->request->all();

        // Check all parameters given
        if (!isset($params["name"]) || !isset($params["address"]) || !isset($params["price_per_night"]) 
        || !isset($params["type"]) || !isset($params["city_id"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Check type of parameters
        if (!is_numeric($params["price_per_night"]) || !is_numeric($params["city_id"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $city = $cityRepository->find($params["city_id"]);

        $hosting = new Hosting();

        $hosting->setName($params["name"]);
        $hosting->setAddress($params["address"]);
        $hosting->setPricePerNight($params["price_per_night"]);
        $hosting->setType($params["type"]);
        $hosting->setCity($city);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($hosting);
        $entityManager->flush();

        $response = $encoder->encoder($hosting);

        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="hosting_show", methods={"GET"})
     */
    public function show(Hosting $hosting, AppEncoder $encoder): Response
    {
        if ($hosting != null) {
            $response = $encoder->encoder($hosting);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/edit/{id}", name="hosting_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param Hosting $hosting
     * @param AppEncoder $encoder
     * @return Response
     */
    public function edit($id, Request $request, Hosting $hosting, AppEncoder $encoder): Response
    {
        if ($hosting != null) {
            $params = $request->request->all();

            $entityManager = $this->getDoctrine()->getManager();
            $hosting = $entityManager->getRepository(Hosting::class)->find($id);
    
            $hosting->setCity($params["city_id"]);
            $hosting->setName($params["name"]);
            $hosting->setAddress($params["address"]);
            $hosting->setPricePerNight($params["price_per_night"]);
            $hosting->setType($params["type"]);
            $entityManager->flush();
    
            $response = $encoder->encoder($hosting);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/delete/{id}", name="hosting_delete", methods={"DELETE"})
     * @param Hosting $hosting
     * @return Response
     */
    public function delete(Hosting $hosting): Response
    {
        if ($hosting != null) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hosting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hosting_index');
    }
}
