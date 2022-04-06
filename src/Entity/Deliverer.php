<?php

namespace App\Entity;

use App\Repository\DelivererRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelivererRepository::class)]
class Deliverer extends User
{
    #[ORM\ManyToOne(targetEntity: post::class, inversedBy: 'delivererID')]
    #[ORM\JoinColumn(nullable: false)]
    private $post;

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
