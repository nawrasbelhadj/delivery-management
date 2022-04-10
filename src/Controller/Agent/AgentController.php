<?php

namespace App\Controller\Agent;
use App\Controller\BackendController;
use App\Entity\Agent;
use App\Entity\User;
use App\Form\User\AddUserFormType;
use App\Form\User\UpdatePasswordFormType;
use App\Service\AgentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AgentController extends BackendController
{
    private AgentService $agentService;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(AgentService $agentService, UserPasswordHasherInterface $passwordHasher)
    {
        $this->agentService = $agentService;
        $this->passwordHasher = $passwordHasher;
    }
    /**
     * @Route("/post/agents", name="agents_list")
     */
    public function index(): Response
    {
        $agents = $this->agentService->getListeAgents();

        return $this->renderViewBackend('users/agents/agents.html.twig', [
            'agents' => $agents,
            'title' => "Agents List",
            'separator' => ' | ',
        ]);
    }


    /**
     * @Route("/agent/add", name="add_agent")
     */
    public function addAgent(Request $request): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AddUserFormType::class, $agent);
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
            $this->addFlash('success', "OK");

            return $this->redirectToRoute('users_list');
        }
        return $this->renderForm('users/agents/addagent.html.twig', [
            'name' => "Nawras",
            'form' => $form
        ]);
    }

}