<?php

namespace App\Entity;

use App\Repository\CourrierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourrierRepository::class)]
class Courrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'bigint')]
    private $codeBarre;

    #[ORM\Column(type: 'string', length: 255)]
    private $postDeparture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeBarre(): ?string
    {
        return $this->codeBarre;
    }

    public function setCodeBarre(string $codeBarre): self
    {
        $this->codeBarre = $codeBarre;

        return $this;
    }

    public function getPostDeparture(): ?string
    {
        return $this->postDeparture;
    }

    public function setPostDeparture(string $postDeparture): self
    {
        $this->postDeparture = $postDeparture;

        return $this;
    }
}
