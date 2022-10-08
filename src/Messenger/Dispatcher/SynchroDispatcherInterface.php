<?php

declare(strict_types=1);

namespace App\Messenger\Dispatcher;

use App\Doctrine\Entity\Synchro;

interface SynchroDispatcherInterface
{
    public function supports(Synchro $synchro): bool;

    public function execute(Synchro $synchro): void;
}
