<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity_index", methods="GET")
     * @param ActivityRepository $activityRepository
     * @param AppEncoder $encoder
     * @return Response
     */
    public function index(ActivityRepository $activityRepository, AppEncoder $encoder)
    {
        $response = $activityRepository->findAll();
        $jsonContent = $encoder->encoder($response);

        return new Response($jsonContent, 200, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("/new", name="activity_new", methods={"GET","POST"})
     * @param Request $request
     * @param AppEncoder $encoder
     * @return Response
     */
    public function new(Request $request, AppEncoder $encoder): Response
    {
        $params = $request->request->all();

        $activity = new Activity($params["duration"], $params["description"], $params["type"], $params["price"], $params["city"]);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($activity);
        $entityManager->flush();$response = $encoder->encoder($activity);
        return new Response($response, 200, ["Content-Type" => "application/json"]);

        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("/view/{id}", name="activity_show", methods={"GET"})
     */
    public function show(Activity $activity, AppEncoder $encoder): Response
    {
        $response = $encoder->encoder($activity);
        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("/edit/{id}", name="activity_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, Activity $activity, AppEncoder $encoder): Response
    {

        $params = $request->request->all();

        $entityManager = $this->getDoctrine()->getManager();
        $activity = $entityManager->getRepository(Activity::class)->find($id);

        if (!$activity) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $activity->setType($params["type"]);
        $activity->setDescription($params["description"]);
        $activity->setDuration($params["duration"]);
        $activity->setPrice($params["price"]);
        $activity->setCity($params["city"]);
        $entityManager->flush();

        $response = $encoder->encoder($activity);
        return new Response($response, 200, ["Content-Type" => "application/json"]);

    }


    /**
     * @Route("/delete/{id}", name="activity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activity $activity): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($activity);
        $entityManager->flush();

        return $this->redirectToRoute('activity_index');
    }
}
