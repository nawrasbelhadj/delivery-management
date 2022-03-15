<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends AbstractController
{
    private const PREFIX = "Delevery Manager";
    private $defaultParamtres = [];


    public function renderViewBackend(string $view, array $parameters = []): Response
    {
        $this->setDefaultParamtres();
        $title = "";
        $prefix = self::PREFIX;

        if (in_array('title', $parameters) === true) {
            $title = $parameters["title"];
        }

        if (in_array('prefix', $parameters) === true) {
            $prefix = $parameters["prefix"];
        }

        $this->setPageTitle($title, $prefix);

        return $this->render($view, array_merge($this->getDefaultParamatres() , $parameters));
    }

    public function setDefaultParamtres(): void
    {
        $this->defaultParamtres = [
            'name' => "Nawras",
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

    public function setPageTitle(string $title = "", string $prefix = self::PREFIX): void
    {
        $this->defaultParamtres['title'] = $prefix . $title;
    }

}
