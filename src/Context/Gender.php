<?php

namespace HeimrichHannot\SalutationCreator\Context;

use HeimrichHannot\SalutationCreator\SalutationPartInterface;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

enum Gender: string implements SalutationPartInterface
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
}
