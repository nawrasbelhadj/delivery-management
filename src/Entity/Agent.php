<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* @Entity
* @InheritanceType("JOINED")
* @DiscriminatorColumn(name="type", type="string")
* @DiscriminatorMap({"agentNormal" = "Normal Agent"})
 */

#[ORM\Entity(repositoryClass: AgentRepository::class)]

class Agent extends User{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: post::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?post
    {
        return $this->post;
    }

    public function setPost(?post $post): self
    {
        $this->post = $post;

        return $this;
    }


}