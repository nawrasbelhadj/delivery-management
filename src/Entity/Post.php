<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[ORM\Column(type: 'bigint')]
    private $namePost;

    #[ORM\Column(type: 'string', length: 50)]
    private $city;

    #[ORM\Column(type: 'text')]
    private $street;

    #[ORM\Column(type: 'string', length: 50)]
    private $regionPost;

    #[ORM\OneToMany(mappedBy: 'codePostal', targetEntity: Agent::class, orphanRemoval: true)]
    private $agentID;

    #[ORM\OneToMany(mappedBy: 'codePostal', targetEntity: Deliverer::class, orphanRemoval: true)]
    private $delivererID;

    public function __construct()
    {
        $this->delivererID = new ArrayCollection();
        $this->agentID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNamePost(): ?string
    {
        return $this->namePost;
    }

    public function setNamePost(string $namePost): self
    {
        $this->namePost = $namePost;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getRegionPost(): ?string
    {
        return $this->regionPost;
    }

    public function setRegionPost(string $regionPost): self
    {
        $this->regionPost = $regionPost;

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgentID(): Collection
    {
        return $this->agentID;
    }

    public function addAgentID(Agent $agentID): self
    {
        if (!$this->agentID->contains($agentID)) {
            $this->agentID[] = $agentID;
            $agentID->setPost($this);
        }

        return $this;
    }

    public function removeAgentID(Agent $agentID): self
    {
        if ($this->agentID->removeElement($agentID)) {
            // set the owning side to null (unless already changed)
            if ($agentID->getPost() === $this) {
                $agentID->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Deliverer>
     */
    public function getDelivererID(): Collection
    {
        return $this->delivererID;
    }

    public function addDelivererID(Deliverer $delivererID): self
    {
        if (!$this->delivererID->contains($delivererID)) {
            $this->delivererID[] = $delivererID;
            $delivererID->setPost($this);
        }

        return $this;
    }

    public function removeDelivererID(Deliverer $delivererID): self
    {
        if ($this->delivererID->removeElement($delivererID)) {
            // set the owning side to null (unless already changed)
            if ($delivererID->getPost() === $this) {
                $delivererID->setPost(null);
            }
        }

        return $this;
    }


}
