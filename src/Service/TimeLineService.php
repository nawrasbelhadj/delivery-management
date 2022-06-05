<?php

namespace App\Service;

use App\Entity\Courrier;
use App\Entity\TimeLine;
use App\Repository\TimeLineRepository;

class TimeLineService
{
    private TimeLineRepository $timelineRepository;

    public function __construct(TimeLineRepository $timeLineRepository)
    {
        $this->timelineRepository = $timeLineRepository;
    }

    public function createTimeLine(Courrier $courrier)
    {
        $timeLine = new TimeLine();
        $timeLine->setCourrier($courrier);
        $timeLine->setPostFrom($courrier->getPostDeparture()->getNamePost());
        $timeLine->setPostTo($courrier->getPostArrival()->getNamePost());
        $timeLine->setStatus($courrier->getStatus());
        $timeLine->setType($courrier->getTypeCourrier());
        $timeLine->setUpdatedAt(new \DateTimeImmutable());
        $timeLine->setObject("Courrier");
        $this->timelineRepository->add($timeLine);
    }

    public function getCourrierEvents(Courrier $courrier): array
    {
        return $this->timelineRepository->getEventsByCourrier($courrier);
    }
}