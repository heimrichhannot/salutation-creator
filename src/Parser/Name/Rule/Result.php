<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name\Rule;

class Result
{
    public function __construct(
        public readonly bool $matched,
        public readonly string $firstName = '',
        public readonly string $lastName = '',
        public readonly mixed $origin = null,
    ) {
    }

    public function with(Result $result): Result
    {
        if (!$result->matched) {
            return $this;
        }

        return new self(
            true,
            '' !== $result->firstName ? $result->firstName : $this->firstName,
            '' !== $result->lastName ? $result->lastName : $this->lastName,
            $this->origin // oder $result->origin, je nach gewünschter Semantik
        );
    }

    public function isComplete(): bool
    {
        return $this->matched && '' !== $this->firstName && '' !== $this->lastName;
    }

    public function isEmpty(): bool
    {
        return '' === $this->firstName && '' === $this->lastName;
    }
}
