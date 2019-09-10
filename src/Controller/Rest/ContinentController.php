<?php

namespace App\Controller\Rest;

use App\Repository\ContinentRepository;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

class ContinentController extends AbstractController
{
    /**
     * Retrieves an Article resource
     * @Rest\Get("/continent/{articleId}")
     * @param ContinentRepository $continentRepository
     * @return View
     */
    public function getContinent(ContinentRepository $continentRepository): View
    {
        $article = $continentRepository->findAll();

        return View::create($article, Response::HTTP_OK);
    }
}
