<?php

namespace App\Service;

use App\Entity\Bordereau;
use App\Entity\Courrier;
use App\Entity\TimeLine;
use App\Repository\BordereauRepository;
use App\Repository\TimeLineRepository;

class BordereauService {
    private BordereauRepository $bordereauRepository;
    private TimeLineRepository $timelineRepository;

    public function __construct(BordereauRepository $bordereauRepository, TimeLineRepository $timeLineRepository)
    {
        $this->bordereauRepository = $bordereauRepository;
        $this->timelineRepository = $timeLineRepository;
    }

    /**
     * @return Bordereau[] Returns an array of Bordereau objects
     */
    public function getListeBord(): array
    {
        return $this->bordereauRepository->findAll();
    }

    /**
     * @return Bordereau Returns an Bordereau objects
     */
    public function getBordereau($id): ?Bordereau
    {
        return $this->bordereauRepository->find($id);
    }


    /**
     * @param $id
     * @return void
     */
    public function deleteBordereau($id): void
    {
        $bordereau =  $this->bordereauRepository->find($id);
        $this->bordereauRepository->deleteBordereau($bordereau);
    }

    /**
     * @param Bordereau $bordereau
     * @return bordereau
     */
    public function saveBordereau(Bordereau $bordereau)
    {
         $this->bordereauRepository->add($bordereau);
    }

    public function createEventBordereau(Courrier $courrier, $type = "Bordereau is created")
    {
        $timeLine = new TimeLine();
        $timeLine->setCourrier($courrier);
        $timeLine->setUpdatedAt(new \DateTimeImmutable());
        $timeLine->setObject("Bordereau");
        $timeLine->setType($type);
        $this->timelineRepository->add($timeLine);
    }
}