<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    private $defaultParamtres = [];

    public function __construct()
    {
        $this->setDefaultParamtres();
    }

    public function renderViewBackend(string $view, array $parameters = []): Response
    {
        return $this->render($view, array_merge($this->getDefaultParamatres() , $parameters));
    }

    public function setDefaultParamtres(): void
    {
        $this->defaultParamtres = [
            'name' => "Nawras",
            'title' => "Users",
        ];
    }

    public function getDefaultParamatres(): array
    {
        return $this->defaultParamtres;
    }

    public function updateDefaultParamtres($key, $value): void
    {
        $this->defaultParamtres[$key] = $value;
    }

}
