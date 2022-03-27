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

    /**
     * @param $id
     * @return void
     */
    public function deleteUser($id): void
    {
        $user =  $this->userRepository->find($id);
        $this->userRepository->deleteUSer($user);
    }

    /**
     * @param User $user
     * @return User
     */
    public function saveUser(User $user): User
    {
        return $this->userRepository->saveUser($user);
    }

    /**
     * @return User Returns an User objects
     */
    public function getUserData($id): User
    {
        return $this->userRepository->find($id);
    }

//    /**
//     * @return Users Returns an User objects
//     */
//    public function getUser($id): ?User
//    {
//        return $this->userRepository->find($id);
//    }

}