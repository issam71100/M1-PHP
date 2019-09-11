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
        $continent = new Continent();

        $continent = new Continent();
        $continent->setName($params["name"]);
        $continent->setImage($params["image"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($continent);
            $entityManager->flush();
            $response = $encoder->encoder($continent);
            return new Response($response, 200, ["Content-Type" => "application/json"]);

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/view/{id}", name="continent_show", methods={"GET"})
     */
    public function show(Continent $continent, AppEncoder $encoder): Response
    {
        $response = $encoder->encoder($continent);
        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }
    // todo continent non trouver

    /**
     * @Route("/edit/{id}", name="continent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Continent $continent): Response
    {
        $form = $this->createForm(ContinentType::class, $continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('continent_index');
        }

        $response = json_encode(array(
            "status" => "error"
        ));
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }

    /**
     * @Route("/{id}", name="continent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Continent $continent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$continent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($continent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('continent_index');
    }
}
