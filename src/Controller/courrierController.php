<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class courrierController extends AbstractController
{
    /**
     * @Route("/history", name="history_courrier")
     */
    public function index(): Response
    {
        return $this->render('courrier/history.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/alert", name="alert_courrier")
     */
    public function list(): Response
    {
        return $this->render('courrier/alert.html.twig');
    }


    /**
     * @Route("/timeline", name="timeline_courrier")
     */
    public function show(): Response
    {
        return $this->render('courrier/timeline.html.twig');
    }

    /**
     * @Route("/archive", name="archive_courrier")
     */
    public function search(): Response
    {
        return $this->render('courrier/archive.html.twig');
    }
}