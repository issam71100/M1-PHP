<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Entity\Trip;
use App\Repository\CityRepository;
use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trip")
 */
class TripController extends AbstractController
{
    /**
     * @Route("/", name="trip_index", methods={"GET"})
     * @param TripRepository $tripRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index(TripRepository $tripRepository, AppEncoder $encoder): Response
    {
        $response = $tripRepository->findAll();
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/new", name="trip_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder, TripRepository $tripRepository, CityRepository $cityRepository): Response
    {
        $params = $request->request->all();

        $entityManager = $this->getDoctrine()->getManager();

        $depart = $cityRepository->findOneByName("Paris");
        var_dump($depart);

        die();

        if (!isset($depart->id) || !isset($params["city_arrival"]) || !isset($params["duration"]) || !isset($params["price"]) || !isset($params["transport"]) ) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $trip = new Trip($params["transport"], $params["duration"], $params["price"], $params["city_departure"], $params["city_arrival"]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($trip);
        $entityManager->flush();

        $response = $encoder->encoder($trip);

        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="trip_show", methods={"GET"})
     * @param Trip $trip
     * @param AppEncoder $encoder
     * @return Response
     */
    public function show(Trip $trip, AppEncoder $encoder): Response
    {
        if ($trip != null) {
            $response = $encoder->encoder($trip);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}/edit", name="trip_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Trip $trip
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    /* public function edit(Request $request, Trip $trip, AppEncoder $encoder, ContinentRepository $continentRepository): Response
    {
        if ($trip != null) {
            $params = $request->request->all();


            $entityManager = $this->getDoctrine()->getManager();

            $continent = $continentRepository->findOneByName($params["continent"]);

            $trip->setName($params["name"]);
            $trip->setImage($params["image"]);
            $trip->setContinent($continent);
            $entityManager->flush();

            $response = $encoder->encoder($trip);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}/edit", name="trip_edit_name", methods={"GET","POST"})
     * @param Request $request
     * @param TripRepository $tripRepository
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    /*
    public function editByName(Request $request, TripRepository $tripRepository, AppEncoder $encoder, ContinentRepository $continentRepository): Response
    {
        $params = $request->request->all();

        if (!isset($params["name"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $trip = $tripRepository->findOneByName($params["name"]);

        if ($trip != null) {
            $params = $request->request->all();

            $entityManager = $this->getDoctrine()->getManager();

            $continent = $continentRepository->findOneByName($params["continent"]);

            $trip->setName($params["name"]);
            $trip->setImage($params["image"]);
            $trip->setContinent($continent);
            $entityManager->flush();

            $response = $encoder->encoder($trip);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("delete/{id}", name="trip_delete", methods={"DELETE"})
     * @param Trip $trip
     * @return Response
     *//*
    public function delete(Trip $trip): Response
    {
        if ($trip != null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trip_index');
    }

    /**
     * @Route("delete/{name}", name="trip_delete_name", methods={"DELETE"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param TripRepository $tripRepository
     * @return Response
     *//*
    public function deleteByName(Request $request,AppEncoder $encoder, TripRepository $tripRepository): Response
    {
        $params = $request->request->all();

        if (!isset($params["name"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $trip = $tripRepository->findOneByName($params["name"]);

        if ($trip != null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trip);
            $entityManager->flush();
            $response = $encoder->encoder($trip);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }
    */
}
