<?php

declare(strict_types=1);

namespace App\Messenger\Dispatcher;

use App\Doctrine\Entity\Synchro;
use App\Exception\NoSynchroDispatcherFoundException;

final class SynchroDispatcher
{
    /**
     * @param SynchroDispatcherInterface[] $processors
     */
    private array $dispatchers;

    public function __construct(iterable $processors)
    {
        $this->dispatchers = $processors instanceof \Traversable ? iterator_to_array($processors) : $processors;
    }

    public function execute(Synchro $synchro): void
    {
        /** @var SynchroDispatcherInterface $dispatcher */
        foreach ($this->dispatchers as $dispatcher) {
            if (!$dispatcher->supports($synchro)) {
                continue;
            }

            $dispatcher->execute($synchro);

            return;
        }

        throw new NoSynchroDispatcherFoundException($synchro);
    }
}
