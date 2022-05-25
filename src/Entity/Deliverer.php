<?php

namespace App\Entity;

use App\Repository\DelivererRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DelivererRepository::class)]
class Deliverer extends User
{

}
