<?php

declare(strict_types=1);

namespace App\Workflow\Subscriber;

use ApiPlatform\Api\IriConverterInterface;
use App\Manager\DataTypeManager;
use App\Messenger\Message\StartSynchro;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\Event\Event;

final class SynchroSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly IriConverterInterface $iriConverter,
        private readonly DataTypeManager $manager
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
             'workflow.synchro.completed.start' => ['start'],
             'workflow.synchro.completed.complete' => ['updateDataType'],
        ];
    }

    public function start(Event $event): void
    {
        $this->messageBus->dispatch(new StartSynchro($this->iriConverter->getIriFromResource($event->getSubject())));
    }

    public function updateDataType(Event $event): void
    {
        $this->manager->updateAfterSynchro($event->getSubject()->getDataType());
    }
}
