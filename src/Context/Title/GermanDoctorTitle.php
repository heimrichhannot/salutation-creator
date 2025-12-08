<?php

namespace HeimrichHannot\SalutationCreator\Context\Title;

use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\SalutationPartResult;
use Symfony\Contracts\Translation\TranslatableInterface;

class GermanDoctorTitle extends AbstractTitle
{
    public function build(): SalutationPartResult
    {
        return new SalutationPartResult(
            message: 'title.german_doctor',
            domain: 'salutation_creator',
            fallback: 'Dr.'
        );
    }

    public function getPosition(): Position
    {
        return Position::PREFIX;
    }

    public function getPriority(): int
    {
        return 6;
    }
}