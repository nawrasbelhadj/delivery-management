<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class alertController extends AbstractController
{


    #[Route('/alert', name: 'alert')]
    public function index(): Response
    {
        return $this->render('courrier/alert.html.twig');
    }


}