<?php

namespace App\Controller\Admin;

use App\Controller\BackendController;
use App\Entity\Courrier;
use App\Form\Courrier\AddCourrierFormType;
use App\Form\Courrier\UpdateCourrierFormType;
use App\Service\CourrierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
            'courrier' => $courrier
        ]);
    }

    /**
     * @Route("/courrier/add", name="add_courrier")
     */
    public function addCourrier(Request $request): Response
    {
        $courrier = new Courrier();
        $form = $this->createForm(AddCourrierFormType::class, $courrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->courrierService->saveCourrier($courrier);
            $this->addFlash('success', "New Courier Has Been Added");

            return $this->redirectToRoute('history_courrier');
        }

        return $this->renderFormBackend('courrier/addCourrier.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/courrier/update/{id}", name="update_courrier")
     */
    public function updateCourrier($id , Request $request): Response
    {
        $courrier = $this->courrierService->getCourrier($id);
        $form = $this->createForm(UpdateCourrierFormType::class, $courrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->courrierService->saveCourrier($courrier);
            $this->addFlash('success', "Courier updated!");

            return $this->redirectToRoute('history_courrier');
        }

        return $this->renderFormBackend('courrier/updateCourrier.html.twig', [
            'form' => $form,
            'courrier' => $courrier
        ]);
    }

    /**
     * @Route("/courrier/delete/{id}", name="remove_courrier")
     */
    public function deleteCourrier($id): Response
    {
        $courrier = $this->courrierService->getCourrier($id);
        $this->courrierService->deleteCourrier($courrier);
        $this->addFlash('success', 'Courier Removed! ');

        return $this->redirectToRoute('history_courrier');
    }
}