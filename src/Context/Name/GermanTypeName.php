<?php

namespace HeimrichHannot\SalutationCreator\Context\Name;

class GermanTypeName extends AbstractName
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName
    ) {}

    function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    function getFormalName()
    {
        return $this->lastName;
    }

    function getGivenName()
    {
        return $this->firstName;
    }
}