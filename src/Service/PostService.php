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
     * @return Post[] Returns an array of Post objects
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
     * @param Post $post
     * @return Post
     */
    public function savePost(Post $post): Post
    {
        return $this->postRepository->savePost($post);
    }

  /**
     * @return Post Returns a Post objects
     */
    public function getPost($id): ?Post
    {
        return $this->postRepository->find($id);
    }

}