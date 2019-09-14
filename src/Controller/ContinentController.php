<?php

namespace App\Controller;

use App\Assets\AppValidatorBase64Images;
use App\Entity\Continent;
use App\Form\ContinentType;
use App\Repository\ContinentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Assets\AppEncoder;


/**
 * @Route("/continent")
 */
class ContinentController extends AbstractController
{
    /**
     * @Route("/", name="continent_index", methods="GET")
     * @param ContinentRepository $continentRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index(ContinentRepository $continentRepository, AppEncoder $encoder)
    {
        $response = $continentRepository->findAll();
        $jsonContent = $encoder->encoder($response);

        $response = new Response();
        $response->headers->set("Content-Type", "application/json");
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($jsonContent);

        return $response;
    }


    /**
     * @Route("/new", name="continent_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @param AppValidatorBase64Images $validator
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder, AppValidatorBase64Images $validator): Response
    {
        $params = $request->request->all();

        // Check all parameters given
        if (!isset($params["name"]) || !isset($params["image"])) {
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
        $uri_image = 'uploads/continents/' . $params["name"] . '.' . $image["type"];
        $myfile = fopen($uri_image, "w") or die("Unable to open file!");
        fwrite($myfile, $file_content);
        fclose($myfile);

        $continent = new Continent($params["name"], $uri_image);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($continent);
        $entityManager->flush();

        $response = $encoder->encoder($continent);


        return new Response($response, 200, ["Content-Type" => "application/json", "Access-Control-Allow-Origin", "*"]);
    }

    /**
     * @Route("/view/{id}", name="continent_show", methods={"GET"})
     * @param Continent $continent
     * @param AppEncoder $encoder
     * @return Response
     */
    public function show(Continent $continent, AppEncoder $encoder): Response
    {
        if ($continent != null) {
            $response = $encoder->encoder($continent);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/edit/{id}", name="continent_edit", methods={"GET","POST"})
     * @param $id
     * @param Request $request
     * @param Continent $continent
     * @param AppEncoder $encoder
     * @return Response
     */
    public function edit(Request $request, Continent $continent, AppEncoder $encoder): Response
    {
        if ($continent != null) {
            $params = $request->request->all();

            if (!isset($params["name"]) || !isset($params["image"])) {
                return new Response(null, 400, ["Content-Type" => "application/json"]);
            }

            $continent->setName($params["name"]);
            $continent->setImage($params["image"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $response = $encoder->encoder($continent);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/delete/{id}", name="continent_delete", methods={"DELETE"})
     * @param AppEncoder $encoder
     * @param Continent $continent
     * @return Response
     */
    public function delete(AppEncoder $encoder, Continent $continent): Response
    {
        if ($continent != null) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($continent);
            $entityManager->flush();

            $response = $encoder->encoder($continent);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }
}
