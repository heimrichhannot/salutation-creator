<?php

namespace HeimrichHannot\SalutationCreator\Context\Name;

class GermanTypeName extends AbstractName
{
    public function __construct(
        public string $firstName,
        public string $lastName,
    ) {
    }

    public function getFullName(): string
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function getFormalName(): string
    {
        return $this->lastName;
    }

    public function getGivenName(): string
    {
        return $this->firstName;
    }
}
