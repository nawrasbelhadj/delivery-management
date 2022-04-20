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



}
