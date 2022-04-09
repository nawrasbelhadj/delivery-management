<?php

namespace App\Controller\Agent;
use App\Controller\BackendController;
use App\Entity\Agent;
use App\Entity\User;
use App\Form\User\AddUserFormType;
use App\Form\User\UpdatePasswordFormType;
use App\Service\AgentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AgentController extends BackendController
{
    private AgentService $agentService;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(AgentService $agentService, UserPasswordHasherInterface $passwordHasher)
    {
        $this->agentService = $agentService;
        $this->passwordHasher = $passwordHasher;
    }
    /**
     * @Route("/post/agents", name="agents_list")
     */
    public function index(): Response
    {
        $agents = $this->agentService->getListeAgents();

        return $this->renderViewBackend('users/agents/agents.html.twig', [
            'agents' => $agents,
            'title' => "Agents List",
            'separator' => ' | ',
        ]);
    }


    /**
     * @Route("/agent/add", name="add_agent")
     */
    public function addagent(Request $request): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AddUserFormType::class, $agent);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()==false ) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }
        elseif ($form->isSubmitted() && $this->isValid())
        {
            $hashedPassword = $this->passwordHasher->hashPassword($agent, $agent->getPassword());
            $agent->setPassword($hashedPassword);
            $role = $request->request->get('add_agent_form')['userRole'];
            $agent->setRoles(array($role));
            $this->agentService->saveAgent($agent);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('users_list');
        }
        return $this->renderForm('users/agents/addagent.html.twig', [
            'name' => "Nawras",
            'form' => $form
        ]);
    }


//    /**
//     * @Route("/agent/info/{id}", name="info_agent")
//     */
//    public function infouser($id): Response
//    {
//        $Users = $this->agentService->getUserData($id);
//
//        return $this->renderViewBackend('users/infouser.html.twig', [
//            'user' => $Users,
//        ]);
//    }
//
//    /**
//     * @Route("/user/update/{id}", name="update_user")
//     */
//    public function updateuser($id , Request $request): Response
//    {
//        $User = $this->userService->getUserData($id);
//        $form = $this->createForm(UpdateUserProfileType::class, $User);
//        $form->handleRequest($request);
//        $formPassword = $this->createForm(UpdatePasswordFormType::class, $User);
//        $formPassword->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid() == false) {
//
//            foreach ($form->getErrors(true) as $error) {
//                $this->addFlash('errors', $error->getMessage());
//            }
//        } elseif ($form->isSubmitted() && $form->isValid()) {
//            $role = $request->request->get('update_user_profile')['userRole'];
////            dd($request);
//            $User->setRoles(array($role));
//            $this->userService->saveUser($User);
//            $this->addFlash('success', "OK");
//
//            return $this->redirectToRoute('users_list');
//        }
//
//
//        if ($formPassword->isSubmitted() && $formPassword->isValid() == false) {
//            foreach ($form->getErrors(true) as $error) {
//                $this->addFlash('errors', $error->getMessage());
//            }
//        }
//        elseif
//        ($formPassword->isSubmitted() && $formPassword->isValid()){
//            $hashedPassword = $this->passwordHasher->hashPassword($User, $User->getPassword());
//            $User->setPassword($hashedPassword);
//            $this->userService->saveUser($User);
//            $this->addFlash('success', "OK");
//
//            return $this->redirectToRoute('users_list');
//
//        }
//
//        return $this->renderForm('users/updateuser.html.twig', [
//            'user' => $User,
//            'name' => "Nawras",
//            'form' => $form,
//            'formpassword' => $formPassword
//
//        ]);
//
//    }
/////**
////     * @Route("/user/update/{id}", name="update_user")
////     */
////    public function updatePassword($id): Response
////    {
////        $User = new User();
////        $User = $this->userService->getUserData($id);
////        $form = $this->createForm(UpdatePasswordFormType::class, $User);
//// //       $form->handleRequest($request);
////
////        if ($form->isSubmitted() && $form->isValid()==false ) {
////
////            foreach ($form->getErrors(true) as $error) {
////                $this->addFlash('errors', $error->getMessage());
////            }
////        }
////        elseif ($form->isSubmitted() && $this->isValid())
////        {
////            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
////            $user->setPassword($hashedPassword);
////            $this->userService->saveUser($user);
////            $this->addFlash('success', "OK");
////
////            return $this->redirectToRoute('users_list');
////        }
////
////        return $this->renderForm('users/updateuser.html.twig', [
////            'user'=>$User,
////            'name' => "Nawras",
////            'form' => $form
////
////        ]);
////    }
//
//    /**
//     * @Route("/user/remove/{id}", name="remove_user")
//     */
//    public function deleteUser($id): Response
//    {
//        $user = $this->userService->getUserData($id);
//        $this->userService->deleteUser($user);
//        $this->addFlash('success', 'User has been deleted successfully !');
//
//        return $this->redirectToRoute('users_list');
//    }
//

}