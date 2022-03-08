<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function getListeUsers(): array
    {
        return $this->userRepository->findAll();
    }
}