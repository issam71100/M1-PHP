<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Assets\AppValidatorBase64Images;
use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\CountryRepository;
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

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/months/{id}", name="city_months", methods="GET")
     * @param CityRepository $cityRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function citiesMonths($id, CityRepository $cityRepository, AppEncoder $encoder)
    {
        // Verify type of parameters
        if (!is_numeric($id)) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $response = $cityRepository->findCitiesByMonthes($id);
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/activity/{name}", name="city_activity", methods="GET")
     * @param $name
     * @param CityRepository $cityRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function citiesActivity($name, CityRepository $cityRepository, AppEncoder $encoder)
    {

        $response = $cityRepository->findCitiesByActivity($name);
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/new", name="city_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param AppValidatorBase64Images $validator
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder,AppValidatorBase64Images $validator, CountryRepository $countryRepository): Response
    {
        $params = $request->request->all();

        // Check all parameters given
        if (!isset($params["name"]) || !isset($params["image"]) || !isset($params["country"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Verify type of parameters
        if (!is_numeric($params["country"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Uploader
        $base_64 = $params["image"];
        try {
            $image = $validator->check_base64_image($base_64);
        } catch (\Exception $e) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $file_content = $image["data"];
        $uri_image = 'uploads/cities/' . $params["name"] . '.' . $image["type"];
        $myfile = fopen($uri_image, "w") or die("Unable to open file!");
        fwrite($myfile, $file_content);
        fclose($myfile);
        // Fin Uploader

        $country = $countryRepository->find(intval($params["country"]));

        $city = new City($params["name"],$uri_image, $country);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($city);
        $entityManager->flush();

        $response = $encoder->encoder($country);

        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="city_show", methods={"GET"})
     * @param City $city
     * @param AppEncoder $encoder
     * @return Response
     */
    public function show(City $city, AppEncoder $encoder): Response
    {
        if ($city != null){
            $response = $encoder->encoder($city);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}/edit", name="country_edit", methods={"GET","POST"})
     * @param Request $request
     * @param City $city
     * @param AppEncoder $encoder
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function edit(Request $request, City $city, AppEncoder $encoder, CountryRepository $countryRepository): Response
    {
        if ($city != null) {
            $params = $request->request->all();

            if (!isset($params["name"]) || !isset($params["image"]) || !isset($params["country"])) {
                return new Response(null, 400, ["Content-Type" => "application/json"]);
            }

            if (!is_numeric($params["country"])) {
                return new Response(null, 400, ["Content-Type" => "application/json"]);
            }

            $country = $countryRepository->findOneByName($params["country"]);

            $city->setName($params["name"]);
            $city->setImage($params["image"]);
            $city->setContry($country);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $response = $encoder->encoder($country);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}", name="city_delete", methods={"DELETE"})
     * @param AppEncoder $encoder
     * @param City $city
     * @return Response
     */
    public function delete(AppEncoder $encoder , City $city): Response
    {
        if ($city != null) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();

            $response = $encoder->encoder($city);

            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }
}
