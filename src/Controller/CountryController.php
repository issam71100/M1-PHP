<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Entity\Country;
use App\Form\CountryType;
use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/country")
 */
class CountryController extends AbstractController
{
    /**
     * @Route("/", name="country_index", methods={"GET"})
     * @param CountryRepository $countryRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index(CountryRepository $countryRepository, AppEncoder $encoder): Response
    {
        $response = $countryRepository->findAll();
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/new", name="country_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder, ContinentRepository $continentRepository): Response
    {
        $params = $request->request->all();

        if (!isset($params["name"]) || !isset($params["image"]) || !isset($params["continent"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $continent = $continentRepository->findOneByName($params["continent"]);

        $country = new Country();
        $country->setName($params["name"]);
        $country->setImage($params["image"]);
        $country->setContinent($continent);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($country);
        $entityManager->flush();

        $response = $encoder->encoder($country);

        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("view/{id}", name="country_show", methods={"GET"})
     * @param Country $country
     * @param AppEncoder $encoder
     * @return Response
     */
    public function show(Country $country, AppEncoder $encoder): Response
    {
        if ($country != null) {
            $response = $encoder->encoder($country);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}/edit", name="country_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Country $country
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    public function edit(Request $request, Country $country, AppEncoder $encoder, ContinentRepository $continentRepository): Response
    {
        if ($country != null){
            $params = $request->request->all();
            $entityManager = $this->getDoctrine()->getManager();

            $continent = $continentRepository->findOneByName($params["continent"]);

            $country->setName($params["name"]);
            $country->setImage($params["image"]);
            $country->setContinent($continent);
            $entityManager->flush();

            $response = $encoder->encoder($country);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("delete/{id}", name="country_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Country $country): Response
    {
        if ($this->isCsrfTokenValid('delete' . $country->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('country_index');
    }
}
