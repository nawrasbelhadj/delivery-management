<?php

namespace App\Service;

use App\Entity\Courrier;
use App\Entity\Post;
use App\Entity\TimeLine;
use App\Repository\CourrierRepository;

class CourrierService {
    private CourrierRepository $courrierRepository;
    private TimeLineService $timeLineService;

    public function __construct(CourrierRepository $courrierRepository, TimeLineService $timeLineService)
    {
        $this->courrierRepository = $courrierRepository;
        $this->timeLineService = $timeLineService;
    }

    /**
    * @return Courrier[] Returns an array of Courrier objects
    */
    public function getListeCourriers(): array
    {
        return $this->courrierRepository->findAll();
    }

    /**
     * @return Courrier[] Returns an array of Courrier objects
     */
    public function getCourrierByPost(Post $post): array
    {
        return $this->courrierRepository->findByPostDeparture($post);
    }

    /**
     * @return Courrier[] Returns an array of Courrier objects
     */
    public function getCourriersByType(string $typeCourrier): array
    {
        return $this->courrierRepository->findByTypeCourrier($typeCourrier);
    }

    /**
     * @return Courrier[] Returns an array of Courrier objects
     */
    public function getCourriersByFiltre(array $filter): array
    {
        //return  $this->courrierRepository->findBy($filter);
        return $this->courrierRepository->findCourrierByFilter($filter);
    }

    /**
    * @return Courrier Returns an Courrier objects
    */
    public function getCourrier($id): ?Courrier 
    {
        return $this->courrierRepository->find($id);
    }


    /**
     * @param $id
     * @return void
     */
    public function deleteCourrier($id): void
    {
        $courrier =  $this->courrierRepository->find($id);
        $this->courrierRepository->deleteCourrier($courrier);
    }

    /**
     * @param Courrier $courrier
     * @return Courrier
     */
    public function saveCourrier(Courrier $courrier): Courrier
    {
        $courrier = $this->courrierRepository->saveCourrier($courrier);

        $this->timeLineService->createTimeLine($courrier);

        return $courrier;
    }

    public function getEventsCourrier(Courrier $courrier): array
    {
        return $this->timeLineService->getCourrierEvents($courrier);
    }
}