<?php

namespace App\Service;

use App\Entity\Deliverer;
use App\Repository\DelivererRepository;

class DelivererService
{
    private DelivererRepository $deliverersRepository;
    public function __construct(DelivererRepository $deliverersRepository)
    {
        $this->deliverersRepository = $deliverersRepository;
    }

    /**
     * @return Deliverer[] Returns an array of Deliverer objects
     */
    public function getListDeliverers(): array
    {
        return $this->deliverersRepository->findAll();
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteDeliverer($id): void
    {
        $deliverer =  $this->deliverersRepository->find($id);
        $this->deliverersRepository->deleteDeliverer($deliverer);
    }

    /**
     * @param Deliverer $deliverer
     * @return Deliverer
     */
    public function saveDeliverer(Deliverer $deliverer): Deliverer
    {
        return $this->deliverersRepository->saveDeliverer($deliverer);
    }



    /**
     * @return Deliverer Returns an Deliverer objects
     */
    public function getDeliverer($id): ?Deliverer
    {
        return $this->deliverersRepository->find($id);
    }

}