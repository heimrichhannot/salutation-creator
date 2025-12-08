<?php

namespace HeimrichHannot\SalutationCreator\Context\Title;

use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

class PrefixTitle extends AbstractTitle
{
    public function __construct(
        private readonly string $title,
    ) {}

    public function getPosition(): Position
    {
        return Position::PREFIX;
    }

    public function build(): SalutationPartResult
    {
        return new SalutationPartResult($this->title);
    }
}