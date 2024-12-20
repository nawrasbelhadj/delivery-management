<?php

namespace App\Controller\Admin;
use App\Controller\BackendController;
use App\Entity\User;
use App\Form\User\AddUserFormType;
use App\Form\User\UpdatePasswordFormType;
use App\Form\User\UpdateUserFormType;
use App\Form\User\UpdateUserProfileType;
use App\Service\AgentService;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



class UsersController extends BackendController
{
    private UserService $userService;
    private UserPasswordHasherInterface $passwordHasher;
    private AgentService $agentService;

    public function __construct(UserService $userService, UserPasswordHasherInterface $passwordHasher, AgentService $agentService)
    {
        $this->userService = $userService;
        $this->passwordHasher = $passwordHasher;
        $this->agentService = $agentService;

    }
    /**
     * @Route("/users", name="list_users")
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


        if ($form->isSubmitted() && $form->isValid()==false ) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $role = $request->request->get('add_user_form')['userRole'];
            $user->setRoles(array($role));
            $this->userService->saveUser($user);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('list_users');
        }

        return $this->renderFormBackend('users/adduser.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @Route("/user/info/{id}", name="info_user")
     */
    public function infouser($id): Response
    {
        $User = $this->getUser();
        $agent = $this->agentService->getAgent($User->getId());

        return $this->renderViewBackend('users/infouser.html.twig', [
            'user' => $User,
            'agent' => $agent
        ]);
    }

    /**
     * @Route("/user/MyProfile", name="my_profile")
     */
    public function myProfile( Request $request): Response
    {
        $User = $this->getUser();
        $agent = $this->agentService->getAgent($User->getId());
        $form = $this->createForm(UpdateUserProfileType::class, $User);
        $form->handleRequest($request);
        $formPassword = $this->createForm(UpdatePasswordFormType::class, $User);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $this->userService->saveUser($User);
            $this->addFlash('success', 'Changes Saved Successfully!');

            return $this->redirectToRoute('my_profile');
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid() == false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($User, $User->getPassword());
            $User->setPassword($hashedPassword);
            $this->userService->saveUser($User);
            $this->addFlash('success', 'Password Updated!');

            return $this->redirectToRoute('my_profile');
        }


        return $this->renderFormBackend('users/profileUser.html.twig', [
            'user' => $User,
            'agent' => $agent,
            'form' => $form,
            'formpassword' => $formPassword
        ]);
    }

    /**
     * @Route("/user/update/{id}", name="update_user")
     */
    public function updateuser($id , Request $request): Response
    {
        $User = $this->userService->getUserData($id);
        $form = $this->createForm(UpdateUserFormType::class, $User);
        $form->handleRequest($request);
        $formPassword = $this->createForm(UpdatePasswordFormType::class, $User);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $request->request->get('update_user_form')['userRole'];
            $User->setRoles(array($role));
            $this->userService->saveUser($User);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('list_users');
        }


        if ($formPassword->isSubmitted() && $formPassword->isValid() == false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($User, $User->getPassword());
            $User->setPassword($hashedPassword);
            $this->userService->saveUser($User);
            $this->addFlash('success', 'User has been updated successfully!');

            return $this->redirectToRoute('list_users');
        }

        return $this->renderFormBackend('users/updateuser.html.twig', [
            'user' => $User,
            'form' => $form,
            'formpassword' => $formPassword

        ]);

    }

    /**
     * @Route("/user/remove/{id}", name="remove_user")
     */
    public function deleteUser($id): Response
    {
        $user = $this->userService->getUserData($id);
        $this->userService->deleteUser($user);
        $this->addFlash('success', 'User has been deleted successfully !');

        return $this->redirectToRoute('list_users');
    }
}