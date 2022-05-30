<?php

namespace App\Service;

use App\Entity\Agent;
use App\Repository\AgentRepository;
use App\Repository\UserRepository;

class AgentService
{
    private AgentRepository $agentRepository;

    public function __construct(AgentRepository $agentRepository)
    {
        $this->agentRepository = $agentRepository;
    }

    /**
     * @return Agent [] Returns an array of Agent objects
     */
    public function getListeAgents(): array
    {
        return $this->agentRepository->findAll();
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteAgent($id): void
    {
        $agent =  $this->agentRepository->find($id);
        $this->agentRepository->deleteAgent($agent);
    }

    /**
     * @param Agent $agent
     * @return Agent
     */
    public function saveAgent(Agent $agent): Agent
    {
        return $this->agentRepository->saveAgent($agent);
    }



    /**
     * @return Agent Returns an Agent objects
     */
    public function getAgent($id): ?Agent
    {
        return $this->agentRepository->find($id);
    }

}