<?php

namespace App\Controller\Deliverer;

use App\Controller\BackendController;
use App\Entity\Bordereau;
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