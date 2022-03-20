<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends AbstractController
{
    private const PREFIX = "Delevery Manager";
    private const SEPARATOR =  "-";
    private $defaultParamtres = [];


    public function renderViewBackend(string $view, array $parameters = []): Response
    {
        $this->setDefaultParamtres();
        $title = "";
        $prefix = self::PREFIX;
        $separator = self::SEPARATOR;


        if (array_key_exists('title', $parameters) === true) {
            $title = $parameters["title"];
            unset($parameters["title"]);
        }

        if (array_key_exists('prefix', $parameters) === true) {
            $prefix = $parameters["prefix"];
            unset($parameters["prefix"]);

        }

        if (array_key_exists('separator', $parameters ) === true) {
            $separator = $parameters["separator"];
            unset($parameters["separator"]);

        }

        $this->setPageTitle($title, $prefix, $separator);


        return $this->render($view, array_merge($this->getDefaultParamatres() , $parameters));
    }

    public function setDefaultParamtres(): void
    {
        $user = $this->getUser();

        $this->defaultParamtres = [
            'name' => $user->getUsername(),
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

    public function setPageTitle(string $title = "", string $prefix = self::PREFIX, string $separator = self::SEPARATOR): void
    {
        $this->defaultParamtres['title'] = $prefix . $separator .$title;
    }

}
