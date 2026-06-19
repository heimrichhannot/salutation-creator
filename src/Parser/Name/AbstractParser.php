<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name;

use HeimrichHannot\SalutationCreator\Context\Name\AbstractName;
use HeimrichHannot\SalutationCreator\Context\Name\GermanTypeName;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Result;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\RuleInterface;

abstract class AbstractParser
{
    private bool $allowIncomplete = false;

    public function __construct(
        /**
         * @var class-string<RuleInterface>[]
         */
        protected array $rules,
        /** @var class-string<AbstractName> */
        protected string $format,
    ) {
        if (!(is_a($this->format, AbstractName::class, true))) {
            throw new \InvalidArgumentException(sprintf('Format class "%s" does not exist or is not a subclass of "%s".', $this->format, AbstractName::class));
        }
    }

    public static function create(string $format): static
    {
        static::validateFormat($format);
        $rules = static::defaultRules($format);

        $instance = new static($rules, $format);
        return $instance;
    }

    public function allowIncomplete(bool $allow): static
    {
        $this->allowIncomplete = $allow;
        return $this;
    }

    public static function validateFormat(string $targetFormat): void
    {
        if (!class_exists($targetFormat) || !is_subclass_of($targetFormat, AbstractName::class)) {
            throw new \InvalidArgumentException(sprintf('Target format class "%s" does not exist or is not a subclass of "%s".', $targetFormat, AbstractName::class));
        }
    }

    protected function buildNameFromResult(Result $result): ?AbstractName
    {
        if (!$result->isComplete() && !$this->allowIncomplete) {
            return null;
        }

        if ($result->isEmpty()) {
            return null;
        }

        /** @var GermanTypeName $name */
        $name = new ($this->format)();
        $name->firstName = $result->firstName;
        $name->lastName = $result->lastName;

        return $name;
    }

    abstract public static function defaultRules(string $format): array;
}