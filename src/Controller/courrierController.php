<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class courrierController extends AbstractController
{
    /**
     * @Route("/courrier/history", name="history_courrier")
     */
    public function index(): Response
    {
        return $this->render('courrier/history.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/courrier/alert", name="alert_courrier")
     */
    public function list(): Response
    {
        return $this->render('courrier/alert.html.twig', ['name' => "nawras"]);
    }


    /**
     * @Route("/courrier/timeline", name="timeline_courrier")
     */
    public function show(): Response
    {
        return $this->render('courrier/timeline.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/courrier/archive", name="archive_courrier")
     */
    public function search(): Response
    {
        return $this->render('courrier/archive.html.twig', ['name' => "nawras"]);
    }
}