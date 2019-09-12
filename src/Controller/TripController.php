<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Trip;
use App\Repository\CityRepository;
use App\Repository\TripRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trip")
 */
class TripController extends AbstractController {
    /**
     * @Route("/", name="trip_index", methods={"GET"})
     * @param TripRepository $tripRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index (TripRepository $tripRepository, AppEncoder $encoder): Response {
        $response = $tripRepository->findAll();
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/new", name="trip_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param CityRepository $cityRepository
     * @return Response
     */
    public function new (Request $request, AppEncoder $encoder, CityRepository $cityRepository): Response {
        $params = $request->request->all();

        $city_departure = $cityRepository->findOneByName("Orly");

        if ($city_departure  == null) {
            return new Response(null, 400, ["Content-type" => "application/json"]);
        }

        if (!isset($params["city_arrival"]) || !isset($params["duration"]) || !isset($params["price"]) || !isset($params["transport"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Verify type of parameters
        if (!is_numeric($params["city_arrival"])||!is_numeric($params["price"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $city_arrival = $cityRepository->find(intval($params["city_arrival"]));

        // Convert timestamp to DateTime
        $s_date = date("Y-M-j h:i", $params["duration"]);
        $duration = new DateTime($s_date);



        $trip = new Trip($params["transport"], $duration, intval($params["price"]), $city_departure, $city_arrival);

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
    public function show (Trip $trip, AppEncoder $encoder): Response {
        if ($trip != null) {
            $response = $encoder->encoder($trip);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("delete/{id}", name="trip_delete", methods={"DELETE"})
     * @param Trip $trip
     * @param AppEncoder $encoder
     * @return Response
     */
    public function delete (Trip $trip, AppEncoder $encoder): Response {
        if ($trip != null) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trip);
            $entityManager->flush();
            $response = $encoder->encoder($trip);

            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }
}
