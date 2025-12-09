<?php

namespace HeimrichHannot\SalutationCreator;

interface SalutationPartInterface
{
    public function build(): SalutationPartResult;
}
