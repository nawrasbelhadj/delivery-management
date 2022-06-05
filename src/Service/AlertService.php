<?php

namespace App\Service;

use App\Entity\Alert;
use App\Repository\AlertRepository;

class AlertService
{
    private AlertRepository $alertRepository;

    public function __construct(AlertRepository $alertRepository)
    {
        $this->alertRepository = $alertRepository;
    }

    /**
     * @param Alert $alert
     * @return Alert
     */
    public function saveAlert(Alert $alert): Alert
    {
        return $this->alertRepository->saveAlert($alert);
    }

    /**
     * @return Alert Returns a Alert objects
     */
    public function getALert($id): ?Alert
    {
        return $this->alertRepository->find($id);
    }

}