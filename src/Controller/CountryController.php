<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Assets\AppValidatorBase64Images;
use App\Entity\Country;
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
     * @param AppValidatorBase64Images $validator
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder,AppValidatorBase64Images $validator, ContinentRepository $continentRepository): Response
    {
        $params = $request->request->all();

        // Check all parameters given
        if (!isset($params["name"]) || !isset($params["image"]) || !isset($params["continent"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Check type of parameters
        if (!is_numeric($params["continent"])) {
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
        $uri_image = 'uploads/countries/' . $params["name"] . '.' . $image["type"];
        $myfile = fopen($uri_image, "w") or die("Unable to open file!");
        fwrite($myfile, $file_content);
        fclose($myfile);


        $continent = $continentRepository->find(intval($params["continent"]));

        $country = new Country();
        $country->setName($params["name"]);
        $country->setImage($uri_image);
        $country->setContinent($continent);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($country);
        $entityManager->flush();

        $response = $encoder->encoder($country);

        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="country_show", methods={"GET"})
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
     * @Route("/edit/{id}", name="country_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Country $country
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    public function edit(Request $request, Country $country, AppEncoder $encoder): Response
    {
        if ($country != null) {
            $params = $request->request->all();

            if (!isset($params["name"]) || !isset($params["image"])){
                return new Response(null, 400, ["Content-Type" => "application/json"]);
            }

            $country->setName($params["name"]);
            $country->setImage($params["image"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $response = $encoder->encoder($country);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}/edit", name="country_edit_name", methods={"GET","POST"})
     * @param Request $request
     * @param CountryRepository $countryRepository
     * @param AppEncoder $encoder
     * @param ContinentRepository $continentRepository
     * @return Response
     */
    public function editByName(Request $request, CountryRepository $countryRepository, AppEncoder $encoder, ContinentRepository $continentRepository): Response
    {
        $params = $request->request->all();

        if (!isset($params["name"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $country = $countryRepository->findOneByName($params["name"]);

        if ($country != null) {
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
     * @param Country $country
     * @param AppEncoder $encoder
     * @return Response
     */
    public function delete(Country $country, AppEncoder $encoder): Response
    {
        if ($country != null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($country);
            $entityManager->flush();

            $response = $encoder->encoder($country);
            return new Response($response, 200, ["Content-Type" => "application/json"]);

        }

        return $this->redirectToRoute('country_index');
    }

    /**
     * @Route("delete/{name}", name="country_delete_name", methods={"DELETE"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param CountryRepository $countryRepository
     * @return Response
     */
    public function deleteByName(Request $request,AppEncoder $encoder, CountryRepository $countryRepository): Response
    {
        $params = $request->request->all();

        if (!isset($params["name"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $country = $countryRepository->findOneByName($params["name"]);

        if ($country != null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($country);
            $entityManager->flush();
            $response = $encoder->encoder($country);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }
}
