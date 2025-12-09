<?php

namespace HeimrichHannot\SalutationCreator\Context\Title;

use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\SalutationPartInterface;

abstract class AbstractTitle implements SalutationPartInterface
{
    abstract public function getPosition(): Position;

    public function getPriority(): int
    {
        return 5;
    }
}
