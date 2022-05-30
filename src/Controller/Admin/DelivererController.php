<?php

namespace App\Controller\Admin;
use App\Controller\BackendController;
use App\Entity\Deliverer;
use App\Entity\User;
use App\Form\Deliverer\AddDelivererFormType;
use App\Form\User\UpdatePasswordFormType;
use App\Form\Deliverer\UpdateDelivererProfileType;
use App\Service\DelivererService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



class DelivererController extends BackendController
{
    private DelivererService $delivererService;
    private UserPasswordHasherInterface $passwordHasher;



    public function __construct(DelivererService $delivererService, UserPasswordHasherInterface $passwordHasher )
    {
        $this->delivererService = $delivererService;
        $this->passwordHasher = $passwordHasher;

    }
    /**
     * @Route("/deliverers/list", name="list_deliverers")
     */
    public function index(): Response
    {
        $deliverer = $this->delivererService->getListDeliverers();

        return $this->renderViewBackend('users/deliverers/deliverers.html.twig', [
            'deliverers' => $deliverer,
            'title' => "Liste Deliverers",
            'separator' => ' | ',
        ]);
    }


    /**
     * @Route("/deliverer/add", name="add_deliverer")
     */
    public function adddeliverer(Request $request): Response
    {
        $deliverer = new Deliverer();
        $form = $this->createForm(AddDelivererFormType::class, $deliverer);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()==false ) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($deliverer, $deliverer->getPassword());
            $deliverer->setPassword($hashedPassword);
            $role = $request->request->get('add_deliverer_form')['userRole'];
            $deliverer->setRoles(array($role));
            $this->delivererService->saveDeliverer($deliverer);
            $this->addFlash('success', "Deliverer Added");

            return $this->redirectToRoute('list_deliverers');
        }

        return $this->renderFormBackend('users/deliverers/adddeliverer.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @Route("/deliverer/view/{id}", name="info_deliverer")
     */
    public function infouser($id): Response
    {
        $deliverer = $this->delivererService->getDeliverer($id);

        return $this->renderViewBackend('users/deliverers/infoDeliverer.html.twig', [
            'deliverer' => $deliverer,
        ]);
    }



    /**
     * @Route("/deliverer/update/{id}", name="update_deliverer")
     */
    public function updatedeliverer($id , Request $request): Response
    {
        $deliverer = $this->delivererService->getDeliverer($id);
        $form = $this->createForm(UpdateDelivererProfileType::class, $deliverer);
        $form->handleRequest($request);
        $formPassword = $this->createForm(UpdatePasswordFormType::class, $deliverer);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $request->request->get('update_deliverer_profile')['userRole'];
            $deliverer->setRoles(array($role));
            $this->delivererService->saveDeliverer($deliverer);
            $this->addFlash('success', "Deliverer Updated");

            return $this->redirectToRoute('deliverers_list');
        }


        if ($formPassword->isSubmitted() && $formPassword->isValid() == false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($deliverer, $deliverer->getPassword());
            $deliverer->setPassword($hashedPassword);
            $this->delivererService->saveDeliverer($deliverer);
            $this->addFlash('success', "Password Changed");

            return $this->redirectToRoute('deliverers_list');
        }

        return $this->renderFormBackend('users/deliverers/updatedeliverer.html.twig', [
            'deliverer' => $deliverer,
            'form' => $form,
            'formpassword' => $formPassword

        ]);

    }
///**
//     * @Route("/user/update/{id}", name="update_user")
//     */
//    public function updatePassword($id): Response
//    {
//        $User = new User();
//        $User = $this->userService->getUserData($id);
//        $form = $this->createForm(UpdatePasswordFormType::class, $User);
// //       $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()==false ) {
//
//            foreach ($form->getErrors(true) as $error) {
//                $this->addFlash('errors', $error->getMessage());
//            }
//        }
//        elseif ($form->isSubmitted() && $this->isValid())
//        {
//            $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
//            $user->setPassword($hashedPassword);
//            $this->userService->saveUser($user);
//            $this->addFlash('success', "OK");
//
//            return $this->redirectToRoute('users_list');
//        }
//
//        return $this->renderForm('users/updateuser.html.twig', [
//            'user'=>$User,
//            'name' => "Nawras",
//            'form' => $form
//
//        ]);
//    }

    /**
     * @Route("/deliverer/remove/{id}", name="remove_deliverer")
     */
    public function deleteDeliverer($id): Response
    {
        $deliverer = $this->delivererService->getDeliverer($id);
        $this->delivererService->deleteDeliverer($deliverer);
        $this->addFlash('success', 'Deliverer has been deleted successfully !');

        return $this->redirectToRoute('deliverers_list');
    }
}