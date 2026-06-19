<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name\Rule;

class RowValue extends Value
{
    public string $originalKey;
    public string $normalizedKey;

    public function __construct(
        string|int $key,
        mixed $value,
    ) {
        parent::__construct($value);

        $this->originalKey = (string) $key;
        $this->normalizedKey = strtolower((string) preg_replace('/[^a-z0-9]/i', '', $this->originalKey));
    }
}
