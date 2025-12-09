<?php

namespace HeimrichHannot\SalutationCreator\Context\Name;

class GermanTypeName extends AbstractName
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName
    ) {}

    function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    function getFormalName(): string
    {
        return $this->lastName;
    }

    function getGivenName(): string
    {
        return $this->firstName;
    }
}