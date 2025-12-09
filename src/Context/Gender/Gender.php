<?php

namespace HeimrichHannot\SalutationCreator\Context\Gender;

use HeimrichHannot\SalutationCreator\SalutationPartResult;

enum Gender: string implements GenderInterface
{
    case FEMALE = 'f';
    case MALE = 'm';
    case DIVERSE = 'd';

    public function build(): SalutationPartResult
    {
        return new SalutationPartResult(
            'gender.' . $this->value,
            domain: 'salutation_creator',
            fallback: ucfirst($this->value),
        );
    }

    public function getKey(): string
    {
        return $this->value;
    }
}
