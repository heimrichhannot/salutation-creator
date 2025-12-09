<?php

namespace HeimrichHannot\SalutationCreator\Context\Title;

use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

class SuffixTitle extends AbstractTitle
{
    public function __construct(
        private readonly string $value,
    ) {
    }

    public function getPosition(): Position
    {
        return Position::SUFFIX;
    }

    public function build(): SalutationPartResult
    {
        return new SalutationPartResult($this->value);
    }
}
