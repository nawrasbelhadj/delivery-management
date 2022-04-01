<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* @Entity
* @InheritanceType("JOINED")
* @DiscriminatorColumn(name="type", type="string")
* @DiscriminatorMap({"normalAgent" = "Normal Agent"})
 */

#[ORM\Entity(repositoryClass: AgentRepository::class)]

class Agent extends User{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}