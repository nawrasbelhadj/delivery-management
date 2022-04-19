<?php

namespace App\Controller\Agent;
use App\Controller\BackendController;
use App\Entity\Agent;
use App\Form\Agent\AddAgentFormType;
use App\Form\Agent\UpdateAgentProfileType;
use App\Form\User\UpdatePasswordFormType;
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

    public function __construct(AgentService $agentService, UserPasswordHasherInterface $passwordHasher , PostService $postService)
    {
        $this->agentService = $agentService;
        $this->passwordHasher = $passwordHasher;
        $this->postService = $postService;
    }
    /**
     * @Route("/post/agents/list/{postid}", name="list_agents")
     */
    public function index($postid): Response
    {

        $agents = $this->agentService->getListeAgents();

        return $this->renderViewBackend('users/agents/agents.html.twig', [
            'agents' => $agents,
            'title' => "Agents List",
            'separator' => ' | ',
            'postid' => $postid,
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

            return $this->redirectToRoute('users_list');
        }
        return $this->renderFormBackend('users/agents/addagent.html.twig', [
            'name' => "Nawras",
            'form' => $form,
            'postid' => $postid
        ]);
    }

    /**
     * @Route("/post/agent/update/{id}", name="update_agent")
     */
    public function updateagent($id , Request $request): Response
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
            $role = $request->request->get('update_user_profile')['userRole'];
            $agent->setRoles(array($role));
            $this->agentService->saveAgent($agent);
            $this->addFlash('success', "Agent updated");

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
            $this->addFlash('success', "Password updated");

            return $this->redirectToRoute('users_list');
        }

        return $this->renderFormBackend('users/updateagent.html.twig', [
            'agent' => $agent,
            'name' => "Nawras",
            'form' => $form,
            'formpassword' => $formPassword

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