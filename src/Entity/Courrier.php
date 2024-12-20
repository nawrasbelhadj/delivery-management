<?php

namespace App\Entity;

use App\Repository\CourrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourrierRepository::class)]
class Courrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string')]
    private $codeBarre;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $postDeparture;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $postArrival;

    #[ORM\Column(type: 'string', length: 20)]
    private $typeCourrier;

    #[ORM\Column(type: 'string', length: 20 , nullable: true)]
    private $status;

    #[ORM\Column(type: 'string', length: 20 , nullable: true)]
    private $situation;

    #[ORM\ManyToOne(targetEntity: Deliverer::class)]
    #[ORM\JoinColumn(nullable: true)]
    private $deliverer;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $message;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updatedAt;

    #[ORM\ManyToMany(targetEntity: Bordereau::class, mappedBy: 'courriers')]
    private $bordereaus;

    #[ORM\OneToMany(mappedBy: 'courierObsolete', targetEntity: Alert::class)]
    private $alertsCourrier;

    public function __construct()
    {
        $this->alertsCourrier = new ArrayCollection();
        $this->bordereaus = new ArrayCollection();
    }

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

    public function getPostDeparture(): ?Post
    {
        return $this->postDeparture;
    }

    public function setPostDeparture(?Post $postDeparture): self
    {
        $this->postDeparture = $postDeparture;

        return $this;
    }

    public function getPostArrival(): ?Post
    {
        return $this->postArrival;
    }

    public function setPostArrival(?Post $postArrival): self
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

    public function getPost(): ?post
    {
        return $this->post;
    }

    public function setPost(?post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function getDeliverer(): ?deliverer
    {
        return $this->deliverer;
    }

    public function setDeliverer(?deliverer $deliverer): self
    {
        $this->deliverer = $deliverer;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Bordereau>
     */
    public function getBordereaus(): Collection
    {
        return $this->bordereaus;
    }

    public function addBordereau(Bordereau $bordereau): self
    {
        if (!$this->bordereaus->contains($bordereau)) {
            $this->bordereaus[] = $bordereau;
            $bordereau->addCourrier($this);
        }

        return $this;
    }

    public function removeBordereau(Bordereau $bordereau): self
    {
        if ($this->bordereaus->removeElement($bordereau)) {
            $bordereau->removeCourrier($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Alert>
     */
    public function getAlertsCourrier(): Collection
    {
        return $this->alertsCourrier;
    }

    public function addAlertsCourrier(Alert $alertsCourrier): self
    {
        if (!$this->alertsCourrier->contains($alertsCourrier)) {
            $this->alertsCourrier[] = $alertsCourrier;
            $alertsCourrier->setCourierObsolete($this);
        }

        return $this;
    }

    public function removeAlertsCourrier(Alert $alertsCourrier): self
    {
        if ($this->alertsCourrier->removeElement($alertsCourrier)) {
            // set the owning side to null (unless already changed)
            if ($alertsCourrier->getCourierObsolete() === $this) {
                $alertsCourrier->setCourierObsolete(null);
            }
        }

        return $this;
    }
}
