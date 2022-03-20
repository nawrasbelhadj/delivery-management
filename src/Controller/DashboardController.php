<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BackendController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        return $this->renderViewBackend('dashboard/index.html.twig',['name' => "nawras"]);
    }
}
