<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class historicController extends AbstractController
{
    #[Route('/historic', name: 'historic')]
    public function index(): Response
    {
        return $this->render('courrier/historic.html.twig');
    }
}