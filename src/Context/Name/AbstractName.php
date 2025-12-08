<?php

namespace HeimrichHannot\SalutationCreator\Context\Name;

use HeimrichHannot\SalutationCreator\SalutationPartInterface;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

abstract class AbstractName implements SalutationPartInterface
{
    public function build(): SalutationPartResult
    {
        return new SalutationPartResult($this->getFullName(), doNotTranslate: true);
    }

    /**
     * Return the full name, e.g. "John Doe"
     */
    abstract function getFullName();

    /**
     * Return the formal name, e.g. "Mr. Doe". Used for formal salutations.
     */
    abstract function getFormalName();

    /**
     * Return the given name, e.g. "John". Used for informal salutations.
     */
    abstract function getGivenName();
}