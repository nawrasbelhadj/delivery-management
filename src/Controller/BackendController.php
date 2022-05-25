<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class BackendController extends AbstractController
{
    private const PREFIX = "Delivery Management";
    private const SEPARATOR =  "-";
    private array $defaultParameters = [];


    public function renderViewBackend(string $view, array $parameters = []): Response
    {
        $this->setDefaultParameters($parameters);

        return $this->render($view, $this->getDefaultParameters());
    }

    public function renderFormBackend(string $view, array $parameters = []): Response
    {
        $this->setDefaultParameters($parameters);

        return $this->renderForm($view, $this->getDefaultParameters());
    }

    public function setDefaultParameters(array $parameters): void
    {
        $this->setPageTitleInDefaultParameters($parameters);
        $this->setUserNameInDefaultParameters();

        $this->defaultParameters = array_merge($this->defaultParameters, $parameters);
    }

    public function getDefaultParameters(): array
    {
        return $this->defaultParameters;
    }

    public function updateDefaultParameters($key, $value): void
    {
        $this->defaultParameters[$key] = $value;
    }

    public function setPageTitleInDefaultParameters(&$parameters): void
    {
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

        $this->defaultParameters['title'] = $prefix . $separator . $title;
    }

    public  function setUserNameInDefaultParameters(): void
    {
        $user = $this->getUser();
        $this->defaultParameters['name'] = $user->getUsername();
    }
}