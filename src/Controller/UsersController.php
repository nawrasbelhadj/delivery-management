<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;

class UsersController extends AbstractController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * @Route("/users", name="users_list")
     */
    public function index(): Response
    {
        $Users = $this->userService->getListeUsers();

        return $this->render('users/users.html.twig', [
            'name' => "nawras",
            'users' => $Users
        ]);
    }
}