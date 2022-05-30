<?php

namespace App\Service;

use App\Entity\Bordereau;
use App\Repository\BordereauRepository;

class BordereauService {
    private BordereauRepository $bordereauRepository;

    public function __construct(BordereauRepository $bordereauRepository)
    {
        $this->bordereauRepository = $bordereauRepository;
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
    public function saveBordereau(Bordereau $bordereau): Bordereau
    {
        return $this->bordereauRepository->saveBordereau($bordereau);
    }
}