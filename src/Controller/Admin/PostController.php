<?php

namespace App\Controller\Admin;

use App\Controller\BackendController;
use App\Entity\Post;
use App\Form\Post\AddPostFormType;
use App\Form\Post\UpdatePostFormType;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends BackendController
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @Route("/post/list", name="list_posts")
     */
    public function index(): Response
    {
        $post = $this->postService->getListePosts();
        return $this->renderViewBackend('post/posts.html.twig', [
            'posts' => $post,
            'title' => "Liste posts",
            'separator' => ' | ',
        ]);
    }

    /**
     * @Route("/post/post2", name="post2")
     */
    public function index2(): Response
    {
        return $this->renderViewBackend('post/post2.html.twig', ['name' => "nawras"]);
    }

    /**
     * @Route("/user/post", name="add_post")
     */
    public function addpost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(AddPostFormType::class, $post);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()==false ) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }
        elseif ($form->isSubmitted() && $this->isValid())
        {


            $this->postService->savePost($post);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('list_posts');
        }
        return $this->renderForm('users/addpost.html.twig', [
            'name' => "Nawras",
            'form' => $form
        ]);
    }

    /**
     * @Route("/post/update/{id}", name="update_post")
     */
    public function updatepost($id , Request $request): Response
    {
        $post = $this->postService->getPost($id);
        $form = $this->createForm(UpdatePostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }
        elseif ($form->isSubmitted() && $form->isValid()) {
            $this->postService->savePost($post);
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('list_posts');
        }

        return $this->renderForm('post/updatePost.html.twig', [
            'post' => $post,
            'name' => "Nawras",
            'form' => $form,

        ]);

    }

    /**
     * @Route("/post/remove/{id}", name="remove_post")
     */
    public function deletePost($id): Response
    {
        $post = $this->postService->getPost($id);

        if ($post === null) {
            $this->addFlash('errors', 'Post not found !');
            return $this->redirectToRoute('list_posts');
        }
        else{
        $this->postService->deletePost($post);
        $this->addFlash('success', 'Post has been deleted successfully !');
        }
        return $this->redirectToRoute('list_posts');
    }
}