<?php

namespace App\Controller\Admin;

use App\Controller\BackendController;
use App\Entity\Courrier;
use App\Form\courrier\AddCourrierFormType;
use App\Service\CourrierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CourrierController extends BackendController
{
    private CourrierService $courrierService;

    public function __construct(CourrierService $courrierService)
    {
        $this->courrierService = $courrierService;
    }

    /**
     * @Route("/courrier/history", name="history_courrier")
     */
    public function index(): Response
    {
        $courriers = $this->courrierService->getListeCourriers();
        
        return $this->renderViewBackend('courrier/history.html.twig', [
            'name' => "nawras",
            'courriers' => $courriers
        ]);
    }

    /**
     * @Route("/courrier/alert", name="alert_courrier")
     */
    public function list(): Response
    {
        return $this->renderViewBackend('courrier/alert.html.twig', ['name' => "nawras"]);
    }


    /**
     * @Route("/courrier/timeline", name="timeline_courrier")
     */
    public function show(): Response
    {
        return $this->renderViewBackend('courrier/timeline.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/courrier/archive", name="archive_courrier")
     */
    public function search(): Response
    {
        return $this->renderViewBackend('courrier/archive.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/courrier/showcourrier/{id}", name="showdemo_courrier")
     */
    public function showCorrier($id): Response
    {
        $courrier = $this->courrierService->getCourrier($id);

        return $this->renderViewBackend('courrier/showcourrier.html.twig', [
            'name' => "Nawras",
            'courrier' => $courrier
        ]);

    }

    /**
     * @Route("/courrier/addcourrier", name="addcourrier_courrier")
     */
    public function addCourrier(Request $request): Response
    {
        $courrier = new Courrier();
        $form = $this->createForm(AddCourrierFormType::class, $courrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->courrierService->saveCourrier($courrier);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('history_courrier');
        }

        return $this->renderForm('courrier/addCourrier.html.twig', [
            'name' => "Nawras",
            'form' => $form
        ]);
    }

    /**
     * @Route("/courrier/updatecourrier/{id}", name="updatecourrier_courrier")
     */
    public function updateCourrier($id): Response
    {
        $courrier = $this->courrierService->getCourrier($id);
        $form = $this->createForm(AddCourrierFormType::class, $courrier);



        return $this->renderForm('courrier/addCourrier.html.twig', [
            'name' => "Nawras",
            'form' => $form
        ]);

    }

    /**
     * @Route("/courrier/deletecourrier/{id}", name="delete_courrier")
     */
    public function deleteCourrier($id): Response
    {
        $courrier = $this->courrierService->getCourrier($id);
        $this->courrierService->deleteCourrier($courrier);
        $this->addFlash('success', 'Article Created! Knowledge is power!');

        return $this->redirectToRoute('history_courrier');
    }

}