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

    #[ORM\Column(type: 'string', length: 255)]
    private $postArrival;



//    #[ORM\Column(type: 'date')]
//    private $departureDate;
//
//    #[ORM\Column(type: 'date', nullable: true)]
//    private $creationDate;

    #[ORM\Column(type: 'string', length: 15)]
    private $typeCourrier;

    #[ORM\Column(type: 'string', length: 20)]
    private $status;

    #[ORM\Column(type: 'string', length: 20)]
    private $situation;

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

    public function getPostArrival(): ?string
    {
        return $this->postArrival;
    }

    public function setPostArrival(string $postArrival): self
    {
        $this->postArrival = $postArrival;

        return $this;
    }


//    public function getDepartureDate(): ?\DateTimeInterface
//    {
//        return $this->departureDate;
//    }
//
//    public function setDepartureDate(\DateTimeInterface $departureDate): self
//    {
//        $this->departureDate = $departureDate;
//
//        return $this;
//    }

    public function getTypeCourrier(): ?string
    {
        return $this->typeCourrier;
    }

    public function setTypeCourrier(string $typeCourrier): self
    {
        $this->typeCourrier = $typeCourrier;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    /**
     * @return mixed
     */
//    public function getCreationDate(): ?\DateTimeInterface
//    {
//        return $this->creationDate;
//    }
//
//    /**
//     * @param mixed $creationDate
//     */
//    public function setCreationDate(DateTimeInterface $creationDate): self
//    {
//        $this->creationDate = $creationDate;
//
//        return $this;
//    }
}
