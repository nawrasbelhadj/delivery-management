<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="bolg_list")
     */
    public function list()
    {
        $user = new User();
        $user->setEmail('mail@mail.com');
        return $this->render('Blog/index.html.twig',
            [
                'nawras' => $user,
                'id' => 5,
            ]);

    }
    /**
     * @Route("/blog/{id}", name="bolg_show")
     */
    public function show( int $id)
    {

        return $this->render('Blog/article.html.twig',
            [
                'id' => $id
            ]);
    }
}