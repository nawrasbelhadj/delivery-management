<?php

namespace App\Entity;

use App\Repository\AlertRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlertRepository::class)]
class Alert
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeAlert;

    #[ORM\ManyToOne(targetEntity: Courrier::class, inversedBy: 'alertsCourrier')]
    private $courierObsolete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeAlert(): ?string
    {
        return $this->typeAlert;
    }

    public function setTypeAlert(string $typeAlert): self
    {
        $this->typeAlert = $typeAlert;

        return $this;
    }

    public function getCourierObsolete(): ?Courrier
    {
        return $this->courierObsolete;
    }

    public function setCourierObsolete(?Courrier $courierObsolete): self
    {
        $this->courierObsolete = $courierObsolete;

        return $this;
    }
}
