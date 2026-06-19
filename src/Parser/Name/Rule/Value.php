<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name\Rule;

class Value
{
    public mixed $originalValue;

    public function __construct(mixed $originalValue)
    {
        $this->originalValue = $originalValue;
    }


}