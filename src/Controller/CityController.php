<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Entity\City;
use App\Repository\CityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @Route("/", name="city_index", methods="GET")
     * @param CityRepository $cityRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index(CityRepository $cityRepository, AppEncoder $encoder)
    {
        $response = $cityRepository->findAll();

        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["ContentType" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="city_show", methods={"GET"})
     * @param City $city
     * @param AppEncoder $encoder
     * @return Response
     */
    public function show(City $city, AppEncoder $encoder): Response
    {
        $cityRep = $this->getDoctrine()
            ->getRepository(City::class)
            ->find($city);

        if (!$cityRep) {
            throw $this->createNotFoundException(
                'No data found for '.$city
            );
        }
        $response = $encoder->encoder($city);
        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}", name="city_delete", methods={"DELETE"})
     * @param Request $request
     * @param City $city
     * @return Response
     */
    public function delete(Request $request, City $city): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->redirectToRoute('city_index');
    }
}
