<?php

declare(strict_types=1);

namespace App\Manager;

use App\Doctrine\Entity\Synchro;
use App\Workflow\Manager\SynchroWorkflowManager;
use Doctrine\ORM\EntityManagerInterface;

final class SynchroManager
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly SynchroWorkflowManager $workflowManager
    ) {
    }

    public function updateNbSteps(Synchro $synchro, int $nbSteps): void
    {
        $synchro->setNbSteps($nbSteps);

        $this->manager->persist($synchro);
        $this->manager->flush();
    }

    public function tryComplete(Synchro $synchro): void
    {
        $this->manager->refresh($synchro);

        if (!$synchro->isProcessed()) {
            return;
        }

        $this->workflowManager->complete($synchro);
    }
}
