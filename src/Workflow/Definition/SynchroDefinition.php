<?php

declare(strict_types=1);

namespace App\Workflow\Definition;

final class SynchroDefinition
{
    public const DRAFT = 'draft';
    public const STARTED = 'started';
    public const COMPLETED = 'completed';

    public const START = 'start';
    public const COMPLETE = 'complete';
}
