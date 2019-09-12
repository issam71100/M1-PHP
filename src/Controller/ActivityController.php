<?php

namespace App\Controller;

use App\Assets\AppEncoder;
use App\Entity\Activity;
use App\Entity\Month;
use App\Repository\ActivityRepository;
use App\Repository\CityRepository;
use DateTime;
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
     * @param CityRepository $cityRepository
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request, AppEncoder $encoder, CityRepository $cityRepository): Response
    {
        $params = $request->request->all();

        // Verify all Activity parameters given
        if (!isset($params["duration"]) || !isset($params["description"]) || !isset($params["type"]) || !isset($params["price"]) || !isset($params["city"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Verify all months parameters given
        if (!isset($params["months"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        // Verify type of parameters
        if (!is_numeric($params["duration"]) || !is_numeric($params["price"]) || !is_numeric($params["city"])) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }

        //Transform Months(Json) to array
        $months = (array)json_decode($params["months"]);

        //Verify months parameter is array
        if ( !is_array($months) || empty($months)) {
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }else{
            foreach ($months as $month){
                if (!is_array($month) || !sizeof($month)==2){
                    return new Response(null, 400, ["Content-Type" => "application/json"]);
                }
            }
        }

        // Convert timestamp to DateTime
        $s_date = date("Y-M-j h:i", $params["duration"]);
        $date = new DateTime($s_date);

        // Recover the activity's City
        $city = $cityRepository->find(intval($params["city"]));

        if ($city == null){
            return new Response(null, 400, ["Content-Type" => "application/json"]);
        }


        // Management of Months
        $years_months= [
            1=>"janvier",
            2=>"fevrier",
            3=>"mars",
            4=>"avril",
            5=>"mai",
            6=>"juin",
            7=>"juillet",
            8=>"aout",
            9=>"septembre",
            10=>"octobre",
            11=>"novembre",
            12=>"decembre",
        ];

        $activity = new Activity($date, $params["description"], $params["type"], $params["price"], $city);

        foreach ($months as $key=>$month){
            if ($months[0]<1 || $month[0]>12){
                return new Response(null, 400, ["Content-Type" => "application/json"]);
            }

            $m = new Month();
            $m->setName($years_months[$month[0]]);
            $m->setTemperatureAvg($month[1]);
            $activity->addMonth($m);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($activity);
        $entityManager->flush();
        $response = $encoder->encoder($activity);
        return new Response($response, 200, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("/view/{id}", name="activity_show", methods={"GET"})
     */
    public function show(Activity $activity, AppEncoder $encoder): Response
    {
        if (!$activity==null) {
            $response = $encoder->encoder($activity);
            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }


    /**
     * @Route("/delete/{id}", name="activity_delete", methods={"DELETE"})
     * @param Activity $activity
     * @param AppEncoder $encoder
     * @return Response
     */
    public function delete(Activity $activity, AppEncoder $encoder): Response
    {
        if ($activity!= null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activity);
            $entityManager->flush();
            $response = $encoder->encoder($activity);

            return new Response($response, 200, ["Content-Type" => "application/json"]);
        }
        return new Response(null, 400, ["Content-Type" => "application/json"]);
    }
}
