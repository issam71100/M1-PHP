<?php

namespace App\Controller;

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

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("/new", name="continent_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder): Response
    {
        $params = $request->request->all();

        if (!isset($params["name"]) || !isset($params["image"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        $continent = new Continent($params["name"], $params["image"]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($continent);
        $entityManager->flush();

        $response = $encoder->encoder($continent);

        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="continent_show", methods={"GET"})
     * @param Continent $continent
     * @param AppEncoder $encoder
     * @return Response
     */
    public function show(Continent $continent, AppEncoder $encoder): Response
    {
        if($continent!=null){
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
        if ($continent!=null){
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
