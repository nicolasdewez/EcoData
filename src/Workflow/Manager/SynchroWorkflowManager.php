<?php

declare(strict_types=1);

namespace App\Workflow\Manager;

use App\Doctrine\Entity\Synchro;
use App\Workflow\Definition\SynchroDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry as Workflow;

final class SynchroWorkflowManager
{
    public function __construct(
        private readonly Workflow $workflow,
        private readonly EntityManagerInterface $manager
    ) {
    }

    public function start(Synchro $synchro): void
    {
        $workflow = $this->workflow->get($synchro);
        if ($workflow->can($synchro, SynchroDefinition::START)) {
            $workflow->apply($synchro, SynchroDefinition::START);
            $this->save($synchro);
        }
    }

    public function complete(Synchro $synchro): void
    {
        $workflow = $this->workflow->get($synchro);
        if ($workflow->can($synchro, SynchroDefinition::COMPLETE)) {
            $workflow->apply($synchro, SynchroDefinition::COMPLETE);
            $this->save($synchro);
        }
    }

    private function save(Synchro $synchro): void
    {
        $this->manager->persist($synchro);
        $this->manager->flush();
    }
}
