<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name\Rule\Array;

use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Result;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\RowValue;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\RuleInterface;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Value;

class EnglishKeyNameRule implements RuleInterface
{
    public function apply(Value $value): Result
    {
        if (!$value instanceof RowValue) {
            return new Result(false);
        }

        if (!is_string($value->originalValue)) {
            return new Result(false);
        }

        if ('firstname' === $value->normalizedKey) {
            return new Result(true, firstName: ucfirst($value->originalValue), origin: $value);
        }
        if (\in_array($value->normalizedKey, ['lastname', 'name'])) {
            return new Result(true, lastName: ucfirst($value->originalValue), origin: $value);
        }

        return new Result(false);
    }
}
