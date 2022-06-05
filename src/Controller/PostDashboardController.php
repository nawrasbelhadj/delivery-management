<?php

namespace App\Controller;

use App\Repository\CourrierRepository;
use App\Service\AgentService;
use App\Service\CourrierService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostDashboardController extends BackendController
{
    private CourrierService $courrierService;
    private AgentService $agentService;
    private CourrierRepository $courrierRepository;

    public function __construct(CourrierService $courrierService, AgentService $agentService, CourrierRepository $courrierRepository )
    {
        $this->courrierService = $courrierService;
        $this->agentService = $agentService;
        $this->courrierRepository = $courrierRepository;
    }

    #[Route('/{postid}', name: 'dashboard')]
    public function index($postid , $postDeparture): Response
    {

        $visitorsChartLabel = ['week1', 'week2', 'week3', 'week4', 'week5', 'week6', 'week7'];
        $visitorsChartDataSets = [
            [
                'type' => 'line',
                'data'=> [90, 120, 170, 167, 180, 177, 160],
                'backgroundColor' => 'transparent',
                'borderColor'=> '#007bff',
                'pointBorderColor'=> '#007bff',
                'pointBackgroundColor'=> '#007bff',
                'fill'=> false
            ],
            [
                'type' => 'line',
                'data'=> [60, 80, 100, 140, 145, 150, 150],
                'backgroundColor' => 'transparent',
                'borderColor'=> '#ced4da',
                'pointBorderColor'=> '#007bff',
                'pointBackgroundColor'=> '#ced4da',
                'fill'=> false
            ]

        ];

        $allCouriersNumbers = count($this->courrierService->getListeCourriers());
        $courriersTypeSimpleNumbers = count($this->courrierService->getCourriersByType("Courrier_Simple"));
        $courriersTypeGrandNumbers = count($this->courrierService->getCourriersByType("Courrier_Grand"));
        $courriersTypeMultipleNumbers = count($this->courrierService->getCourriersByType("Courrier_Multiple"));

        $donutData = [
            [
                'label' => 'Simple',
                'data' => ($courriersTypeSimpleNumbers  * 100 ) / $allCouriersNumbers,
                'color' => '#3c8dbc'
            ],
            [
                'label' => 'Grand',
                'data' => ($courriersTypeGrandNumbers  * 100 ) / $allCouriersNumbers,
                'color' => '#0073b7'
            ]
            ,
            [
                'label' => 'Multiple',
                'data' => ($courriersTypeMultipleNumbers  * 100 ) / $allCouriersNumbers,
                'color' => '#00c0ef'
            ]
        ];

        $couriers = $this->courrierRepository->findBy(['postDeparture'=> $postDeparture]);

        return $this->renderViewBackend('post/dashboardPost/index.html.twig', [
            "visitorsChartLabel" => json_encode($visitorsChartLabel),
            'visitorsChartDataSets' => json_encode($visitorsChartDataSets),
            "donutData" => json_encode($donutData),
            'postid' => $postid,
            'couriers' => $couriers,
            'postDeparture'=> $postDeparture
        ]);
    }
}
