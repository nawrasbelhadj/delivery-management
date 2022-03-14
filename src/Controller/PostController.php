<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post/post1", name="post1")
     */
    public function index(): Response
    {
        return $this->render('post/post1.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/post/post2", name="post2")
     */
    public function index2(): Response
    {
        return $this->render('post/post2.html.twig', ['name' => "nawras"]);
    }
}