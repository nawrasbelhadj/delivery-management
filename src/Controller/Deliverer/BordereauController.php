<?php

namespace App\Controller\Deliverer;

use App\Controller\BackendController;
use App\Entity\Bordereau;
use App\Form\Bordereau\BordereauFormType;
use App\Service\BordereauService;
use App\Service\CourrierService;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BordereauController extends BackendController
{
    private BordereauService $bordereauService;
    private CourrierService $courrierService;
    private PostService $postService;

    public function __construct(BordereauService $bordereauService , PostService $postService , CourrierService $courrierService)
    {
        $this->bordereauService = $bordereauService;
        $this->courrierService = $courrierService;
        $this->postService = $postService;
    }

    /**
     * @Route("/bordereau", name="history_bordereau")
     */
    public function index(): Response
    {
        $bordereaus = $this->bordereauService->getListeBord();

        return $this->renderViewBackend('bordereau/history.html.twig', [
            'bordereaus' => $bordereaus
        ]);
    }

    /**
     * @Route("/bordereau/create", name="create_bordereau")
     */
    public function createBordereau(Request $request): Response
    {
        $bordereau = new Bordereau();
        $form = $this->createForm(BordereauFormType::class, $bordereau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()==false ) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $bordereau->setCreatedAt(new \DateTimeImmutable());
            $courriers = $form->get('courriers')->getData();

            foreach ($courriers as $courrier) {
                $bordereau->addCourrier($courrier);

                // add event create boredereau to timeLine
                $this->bordereauService->createEventBordereau($courrier, "Bordereau is created");
            }

            $this->bordereauService->saveBordereau($bordereau);
            $this->addFlash('success', "New Bordereau Has Been Added");

            return $this->redirectToRoute('show_bordereau', ["id" => $bordereau->getId() ]);
        }

        return $this->renderFormBackend('bordereau/createBordereau.html.twig', [
            "form" => $form
        ]);
    }

    /**
     * @Route("/bordereau/show/{id}", name="show_bordereau")
     */
    public function showBordereau($id): Response
    {
        $bordereau = $this->bordereauService->getBordereau($id);

        return $this->renderViewBackend('bordereau/bordereau.html.twig', [
            "bordereau" => $bordereau
        ]);
    }

    /**
     * @Route("/bordereau/validate/{id}", name="validate_bordereau")
     */
    public function validateBordereauOk($id): Response
    {
        $bordereau = $this->bordereauService->getBordereau($id);

        if ($bordereau->getValidatedAt() === null) {
            $bordereau->setValidatedAt(new \DateTimeImmutable());
            $this->bordereauService->saveBordereau($bordereau);

            foreach ($bordereau->getCourriers() as $courrier) {
                $this->bordereauService->createEventBordereau($courrier, "Validate Bordereau");
            }

            $this->addFlash('success', "Bordereau Has Been Validated");
        }

        return $this->renderViewBackend('bordereau/bordereau.html.twig', [
            "bordereau" => $bordereau
        ]);
    }

    /**
     * @Route("/bordereau/delete/{id}", name="remove_bordereau")
     */
    public function deleteBordereau($id): Response
    {
        $bordereau = $this->bordereauService->getBordereau($id);
        $this->bordereauService->deleteBordereau($bordereau);
        $this->addFlash('success', 'Bordereau Removed! ');

        return $this->redirectToRoute('history_courrier');
    }
}