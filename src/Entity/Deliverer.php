<?php

namespace App\Entity;

use App\Repository\DelivererRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelivererRepository::class)]
class Deliverer extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
