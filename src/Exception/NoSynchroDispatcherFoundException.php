<?php

declare(strict_types=1);

namespace App\Exception;

use App\Doctrine\Entity\Synchro;

final class NoSynchroDispatcherFoundException extends \RuntimeException
{
    public function __construct(Synchro $synchro)
    {
        parent::__construct(sprintf('No synchro dispatcher found for data type "%s"', $synchro->getDataType()->getCode()));
    }
}
