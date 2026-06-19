<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name\Rule;

use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Result;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Value;

interface RuleInterface
{
    public function apply(Value $value): Result;
}