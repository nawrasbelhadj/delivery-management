<?php

namespace App\Controller\Admin;

use App\Controller\BackendController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends BackendController
{
    /**
     * @Route("/post/post1", name="post1")
     */
    public function index(): Response
    {
        return $this->renderViewBackend('post/post1.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/post/post2", name="post2")
     */
    public function index2(): Response
    {
        return $this->renderViewBackend('post/post2.html.twig', ['name' => "nawras"]);
    }
}