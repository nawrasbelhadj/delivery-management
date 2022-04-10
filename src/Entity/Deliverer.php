<?php

namespace App\Entity;

use App\Repository\DelivererRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelivererRepository::class)]
class Deliverer extends User
{
    #[ORM\ManyToOne(targetEntity: Post::class, inversedBy: 'delivererID')]
    #[ORM\JoinColumn(nullable: false)]
    private $post;

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }


}
