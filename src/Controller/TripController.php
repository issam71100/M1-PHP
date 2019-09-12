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
     * @param TripRepository $tripRepository
     * @param CityRepository $cityRepository
     * @return Response
     */
    public function new (Request $request, AppEncoder $encoder, CityRepository $cityRepository): Response {
        $params = $request->request->all();

        $entityManager = $this->getDoctrine()->getManager();

        $depart = $cityRepository->findOneByName("Paris");

        if ($depart->getId() == null) {
            return new Response(null, 400, ["Content-type" => "application/json"]);
        }

        if ($depart->getId() !== null || !isset($params["city_arrival"]) || !isset($params["date_departure"]) || !isset($params["date_arrival"]) || !isset($params["duration"]) || !isset($params["price"]) || !isset($params["transport"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $trip = new Trip($params["transport"], $params["duration"], $params["price"], $depart->getId(), $params["city_arrival"]);

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
     * @Route("/edit/{id}", name="trip_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Trip $trip
     * @param AppEncoder $encoder
     * @param CityRepository $cityRepository
     * @return Response
     */
    public function edit (Request $request, Trip $trip, AppEncoder $encoder, CityRepository $cityRepository): Response {
        if ($trip != null) {
            $params = $request->request->all();

            $depart = $cityRepository->findOneByName("Paris");

            $entityManager = $this->getDoctrine()->getManager();
            if ($depart->getId() !== null || !isset($params["city_arrival"]) || !isset($params["date_departure"]) || !isset($params["date_arrival"]) || !isset($params["duration"]) || !isset($params["price"]) || !isset($params["transport"])) {
                $trip->setCityDeparture($depart);
                $trip->setCityArrival($params["city_arrival"]);
                $trip->setDuration($params["duration"]);
                $trip->setPrice($params["price"]);
                $trip->setTransport($params["transport"]);
                $entityManager->flush();

                $response = $encoder->encoder($trip);
                return new Response($response, 200, ["Content-Type" => "application/json"]);

            }
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("delete/{id}", name="trip_delete", methods={"DELETE"})
     * @param Trip $trip
     * @return Response
     */
    public function delete (Trip $trip): Response {
        if ($trip != null) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trip_index');
    }
}
