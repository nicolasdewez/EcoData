<?php

declare(strict_types=1);

namespace App\EventDispatcher\Subscriber;

use App\EventDispatcher\Event\SynchroCreatedEvent;
use App\Workflow\Manager\SynchroWorkflowManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SynchroSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly SynchroWorkflowManager $manager)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SynchroCreatedEvent::class => ['start'],
        ];
    }

    public function start(SynchroCreatedEvent $event): void
    {
        $this->manager->start($event->getSynchro());
    }
}
