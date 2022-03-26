<?php

namespace App\Controller\Admin;
use App\Controller\BackendController;
use App\Entity\User;
use App\Form\AddUserFormType;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends BackendController
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

        return $this->renderViewBackend('users/users.html.twig', [
            'users' => $Users,
            'title' => "Liste users",
            'separator' => ' | ',
        ]);
    }


    /**
     * @Route("/user/add", name="add_user")
     */
    public function adduser(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(AddUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->saveUser($user);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('users_list');
        }
        return $this->renderForm('users/adduser1.html.twig', [
            'name' => "Nawras",
            'form' => $form
        ]);
    }


    /**
     * @Route("/user/info/{id}", name="info_user")
     */
    public function infouser($id): Response
    {
        $Users = $this->userService->getUserData($id);

        return $this->renderViewBackend('users/infouser.html.twig', [
            'user' => $Users,
        ]);
    }


    /**
     * @Route("/user/remove", name="remove_user")
     */
    public function deleteUser($id): Response
    {
        $user = $this->userService->getUser($id);
        $this->userService->deleteUser($user);
        $this->addFlash('success', 'User has been deleted successfully !');

        return $this->redirectToRoute('users_list');
    }
}