<?php

namespace HeimrichHannot\SalutationCreator\Context\Title;

use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

class GermanProfessorTitle extends AbstractTitle
{
    public function build(): SalutationPartResult
    {
        return new SalutationPartResult(
            message: 'title.german_professor',
            domain: 'salutation_creator',
            fallback: 'Prof.'
        );
    }

    public function getPriority(): int
    {
        return 7;
    }

    public function getPosition(): Position
    {
        return Position::PREFIX;
    }
}
