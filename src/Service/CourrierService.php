<?php

namespace App\Service;

use App\Repository\CourrierRepository;

class CourrierService {
    private CourrierRepository $courrierRepository;

    public function __construct(CourrierRepository $courrierRepository)
    {
        $this->courrierRepository = $courrierRepository;
    }

    /**
    * @return Courrier[] Returns an array of Courrier objects
    */
    public function getListeCourriers(): array
    {
        return $this->courrierRepository->findAll();
    }

    /**
    * @return Courrier Returns an Courrier objects
    */
    public function getCourrier($id): ?Courrier 
    {
        return $this->courrierRepository->find($id);
    }

}