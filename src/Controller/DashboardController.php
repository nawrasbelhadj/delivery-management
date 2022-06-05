<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Courrier;
use App\Service\CourrierService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BackendController
{
    private CourrierService $courrierService;

    public function __construct(CourrierService $courrierService)
    {
        $this->courrierService = $courrierService;
    }

    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user instanceof Agent) {
            return $this->getDashboardAgent();
        }

        return $this->getDefaultDashboard();
    }

    public function getDashboardAgent()
    {
        $user = $this->getUser();

        if ($user instanceof Agent === false) {
            return $this->getDefaultDashboard();
        }

        $post = $user->getPost();

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

        $listCourriers = $this->courrierService->getCourrierByPost($post);
        $allCouriersNumbers = count($listCourriers);


        $courriersTypeSimpleNumbers = count($this->courrierService->getCourriersByFiltre(["postDeparture" => $post, "typeCourrier" => "Courrier_Simple"]));
        $courriersTypeGrandNumbers = count($this->courrierService->getCourriersByFiltre(["postDeparture" => $post, "typeCourrier" => "Courrier_Grand"]));
        $courriersTypeMultipleNumbers = count($this->courrierService->getCourriersByFiltre(["postDeparture" => $post, "typeCourrier" => "Courrier_Multiple"]));


        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d-m-Y", $firstDayUTS);
        $lastDay = date("d-m-Y", $lastDayUTS);

        $fromDate = new \DateTimeImmutable($firstDay);
        $toDate = new \DateTimeImmutable($lastDay);

        $filter = [
            "postDeparture" => $post,
            "fromDate" => $fromDate,
            "toDate" => $toDate,
        ];

        $monthlyCourrier = $this->courrierService->getCourriersByFiltre($filter);




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

        return $this->renderViewBackend('post/dashboardPost.html.twig', [
            "monthlyCourrier" => count($monthlyCourrier),
            "visitorsChartLabel" => json_encode($visitorsChartLabel),
            'visitorsChartDataSets' => json_encode($visitorsChartDataSets),
            "donutData" => json_encode($donutData),
            'postid' => $post->getId(),
            'courriers' => $listCourriers,
            'postDeparture'=> $post
        ]);
    }

    public function getDefaultDashboard()
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
                'data' => $allCouriersNumbers !== 0 ? ($courriersTypeSimpleNumbers  * 100 ) / $allCouriersNumbers : 0,
                'color' => '#3c8dbc'
            ],
            [
                'label' => 'Grand',
                'data' => $allCouriersNumbers !== 0 ? ($courriersTypeGrandNumbers  * 100 ) / $allCouriersNumbers : 0,
                'color' => '#0073b7'
            ]
            ,
            [
                'label' => 'Multiple',
                'data' => $allCouriersNumbers !== 0 ? ($courriersTypeMultipleNumbers  * 100 ) / $allCouriersNumbers : 0,
                'color' => '#00c0ef'
            ]
        ];

        return $this->renderViewBackend('dashboard/index.html.twig', ["visitorsChartLabel" => json_encode($visitorsChartLabel), 'visitorsChartDataSets' => json_encode($visitorsChartDataSets), "donutData" => json_encode($donutData)]);
    }
}
