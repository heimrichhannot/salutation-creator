<?php

namespace HeimrichHannot\SalutationCreator\Context\Gender;

use HeimrichHannot\SalutationCreator\SalutationPartInterface;

interface GenderInterface  extends SalutationPartInterface
{
    public function getKey(): string;
}