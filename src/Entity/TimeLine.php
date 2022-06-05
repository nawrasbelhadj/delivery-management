<?php

namespace App\Entity;

use App\Repository\TimeLineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeLineRepository::class)]
class TimeLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Courrier::class)]
    private $courrier;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $status;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updatedAt;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $userName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $postFrom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $postTo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourrier(): ?Courrier
    {
        return $this->courrier;
    }

    public function setCourrier(?Courrier $courrier): self
    {
        $this->courrier = $courrier;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getPostFrom(): ?string
    {
        return $this->postFrom;
    }

    public function setPostFrom(?string $postFrom): self
    {
        $this->postFrom = $postFrom;

        return $this;
    }

    public function getPostTo(): ?string
    {
        return $this->postTo;
    }

    public function setPostTo(?string $postTo): self
    {
        $this->postTo = $postTo;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
