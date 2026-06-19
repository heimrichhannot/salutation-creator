<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name\Rule;

interface RuleInterface
{
    public function apply(Value $value): Result;
}
