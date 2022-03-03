<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimelineController extends  AbstractController
{
    #[Route('/timeline', name: 'timeline')]
    public function index(): Response
    {
        return $this->render('courrier/timeline.html.twig');
    }
}