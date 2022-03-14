<?php

namespace App\Controller;

use App\Entity\Courrier;
use App\Form\AddCourrierFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CourrierService;

class CourrierController extends AbstractController
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
        
        return $this->render('courrier/history.html.twig', [
            'name' => "nawras",
            'courriers' => $courriers
        ]);
    }

    /**
     * @Route("/courrier/alert", name="alert_courrier")
     */
    public function list(): Response
    {
        return $this->render('courrier/alert.html.twig', ['name' => "nawras"]);
    }


    /**
     * @Route("/courrier/timeline", name="timeline_courrier")
     */
    public function show(): Response
    {
        return $this->render('courrier/timeline.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/courrier/archive", name="archive_courrier")
     */
    public function search(): Response
    {
        return $this->render('courrier/archive.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/courrier/showcourrier/{id}", name="showdemo_courrier")
     */
    public function showCorrier($id): Response
    {
        $courrier = $this->courrierService->getCourrier($id);

        return $this->render('courrier/showcourrier.html.twig', [
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