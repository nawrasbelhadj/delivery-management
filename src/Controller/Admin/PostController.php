<?php

namespace App\Controller\Admin;

use App\Controller\BackendController;
use App\Entity\Post;
use App\Form\Post\AddPostFormType;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends BackendController
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

//    /**
//     * @Route("/post/gov", name="list_gov")
//     */
//    public function index(): Response
//    {
//        $post = $this->postService->getListePosts();
//
//        return $this->renderViewBackend('post/listPosts.html.twig', [
//            'posts' => $post,
//            'title' => "Governorates list",
//            'separator' => ' | ',
//        ]);
//    }

    /**
     * @Route("/post/list", name="list_posts")
     */
    public function listPosts(): Response
    {
        $post = $this->postService->getListePosts();

        return $this->renderViewBackend('post/posts.html.twig', [
            'posts' => $post,
            'title' => "Posts list",
            'separator' => ' | ',
        ]);
    }

    /**
     * @Route("/post/add", name="add_post")
     */
    public function addPost(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(AddPostFormType::class, $post);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() === false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->postService->savePost($post);
            $this->addFlash('success', "New post added");

            return $this->redirectToRoute('list_posts');
        }

        return $this->renderFormBackend('post/addpost.html.twig', [
            'form' => $form
        ]);
    }



    /**
     * @Route("/post/remove/{id}", name="remove_post")
     */
    public function deletePost($id): Response
    {
        $post = $this->postService->getPost($id);
        $this->postService->deletePost($post);
        $this->addFlash('success', 'Post has been deleted successfully !');

        return $this->redirectToRoute('list_posts');
    }
}