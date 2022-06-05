<?php

namespace App\Controller\Agent;
use App\Controller\BackendController;
use App\Entity\Agent;
use App\Form\Agent\AddAgentFormType;
use App\Form\Agent\UpdateAgentProfileType;
use App\Form\User\UpdatePasswordFormType;
use App\Repository\AgentRepository;
use App\Service\AgentService;
use App\Service\PostService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;



class AgentController extends BackendController
{
    private AgentService $agentService;
    private UserPasswordHasherInterface $passwordHasher;
    private PostService $postService;
    private AgentRepository $agentRepository;

    public function __construct(AgentService $agentService, UserPasswordHasherInterface $passwordHasher , PostService $postService, AgentRepository $agentRepository)
    {
        $this->agentService = $agentService;
        $this->passwordHasher = $passwordHasher;
        $this->postService = $postService;
        $this->agentRepository = $agentRepository;
    }

//    /**
//     * @Route("/post/agents/list/{postid}", name="list_agents")
//     */
//    public function index($postid): Response
//    {
//
//        $agents = $this->agentService->getListeAgents();
//
//        return $this->renderViewBackend('users/agents/agents.html.twig', [
//            'agents' => $agents,
//            'title' => "Agents List",
//            'separator' => ' | ',
//            'postid' => $postid,
//        ]);
//    }


    /**
     * @Route("/post/agents/list/{postId}", name="list_agents_post")
     */
    public function listeByPost(int $postId): Response
    {
        $agents = $this->agentRepository->findBy(['post'=> $postId]);

        return $this->renderViewBackend('post/agentsPost.html.twig', [
            'agents' => $agents,
            'title' => "Agents List",
            'separator' => ' | ',
            'postId' => $postId,
        ]);
    }


    /**
     * @Route("/post/agent/add/{postid}", name="add_agent")
     */
    public function addAgent($postid , Request $request): Response
    {
        $post = $this->postService->getPost($postid);
        if ($post == null){
            $this->addFlash('errors', 'post not found');

            return $this->redirectToRoute('list_posts');
        }

        $agent = new Agent();
        $agent->setPost($post);
        $form = $this->createForm(AddAgentFormType::class, $agent);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()==false ) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }
        elseif ($form->isSubmitted() && $form->isValid())
        {
            $hashedPassword = $this->passwordHasher->hashPassword($agent, $agent->getPassword());
            $agent->setPassword($hashedPassword);
            $role = $request->request->get('add_agent_form')['userRole'];
            $agent->setRoles(array($role));
            $this->agentService->saveAgent($agent);
            $this->addFlash('success', "New agent was added");

            return $this->redirectToRoute('list_agents', ['postid'=>$postid]);
        }
        return $this->renderFormBackend('users/agents/addagent.html.twig', [

            'form' => $form,
            'postid' => $postid
        ]);
    }

    /**
     * @Route("/post/agent/update/{postid}/{id}", name="update_agent")
     */
    public function updateagent($postid ,$id , Request $request): Response
    {
        $agent = $this->agentService->getAgent($id);
        $form = $this->createForm(UpdateAgentProfileType::class, $agent);
        $form->handleRequest($request);
        $formPassword = $this->createForm(UpdatePasswordFormType::class, $agent);
        $formPassword->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() == false) {

            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $role = $request->request->get('update_agent_profile')['userRole'];
            $agent->setRoles(array($role));
            $this->agentService->saveAgent($agent);
            $this->addFlash('success', "Agent Updated");

            return $this->redirectToRoute('users_list');
        }


        if ($formPassword->isSubmitted() && $formPassword->isValid() == false) {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('errors', $error->getMessage());
            }
        }

        if ($formPassword->isSubmitted() && $formPassword->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword($agent, $agent->getPassword());
            $agent->setPassword($hashedPassword);
            $this->agentService->saveAgent($agent);
            $this->addFlash('success', "Password Changed");

            return $this->redirectToRoute('users_list');
        }

        return $this->renderFormBackend('users/agents/updateagent.html.twig', [
            'agent' => $agent,
            'form' => $form,
            'formpassword' => $formPassword,
            'postid' => $postid

        ]);

    }


    /**
     * @Route("/agent/view/{postid}/{id}", name="info_agent")
     */
    public function infouser($postid , $id): Response
    {
        $agent = $this->agentService->getAgent($id);

        return $this->renderViewBackend('users/agents/infoAgent.html.twig', [
            'agent' => $agent,
            'postid'=> $postid
        ]);
    }


    /**
     * @Route("/post/agent/remove/{id}", name="remove_agent")
     */
    public function deleteAgent($id): Response
    {
        $agent= $this->agentService->getAgent($id);
        $this->agentService->deleteAgent($agent);
        $this->addFlash('success', 'Agent has been deleted successfully !');

        return $this->redirectToRoute('agents_list');
    }
}