<?php

namespace App\Controller;

use App\Controller\BackendController;
use App\Entity\Alert;
use App\Form\Alert\AddAlertFormType;
use App\Service\AlertService;
use App\Service\CourrierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlertController extends BackendController
{
    private AlertService $alertService;
    private CourrierService $courrierService;

    public function __construct(AlertService $alertService , CourrierService $courrierService)
    {
        $this->alertService = $alertService;
        $this->courrierService = $courrierService;
    }




    /**
     * @Route("/courrier/alert/{id}", name="alert_courrier")
     */
    public function addAlert($id , Request $request): Response
    {
        $courrier = $this->courrierService->getCourrier($id);
        $alert = new Alert();
        $form = $this->createForm(AddAlertFormType::class, $alert);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() === false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->alertService->saveAlert($alert);
            $this->addFlash('success', "New Alert declared");

            return $this->redirectToRoute('history_courrier');
        }

        return $this->renderFormBackend('courrier/alert.html.twig', [
            'form' => $form,
            'courrier' => $courrier
        ]);
    }

}