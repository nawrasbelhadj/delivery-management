<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;

class PostService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return Post[] Returns an array of User objects
     */
    public function getListePosts(): array
    {
        return $this->postRepository->findAll();
    }

    /**
     * @param $id
     * @return void
     */
    public function deletePost($id): void
    {
        $post =  $this->postRepository->find($id);
        $this->postRepository->deletePost($post);
    }

    /**
     * @param Post $Post
     * @return Post
     */
    public function saveUser(Post $post): Post
    {
        return $this->postRepository->savePost($post);
    }



    /**
     * @return Posts Returns an Post objects
     */
    public function getPost($id): ?Post
    {
        return $this->postRepository->find($id);
    }

}