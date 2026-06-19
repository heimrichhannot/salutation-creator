<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name;

use HeimrichHannot\SalutationCreator\Context\Name\AbstractName;
use HeimrichHannot\SalutationCreator\Context\Name\GermanTypeName;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Array\EnglishKeyNameRule;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Array\GermanKeyNameRule;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Result;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\RowValue;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\RuleInterface;
use HeimrichHannot\SalutationCreator\Parser\Name\ValueObject\ArrayRow;
use HeimrichHannot\SalutationCreator\Parser\Name\ValueObject\Name;

class ArrayParser extends AbstractParser
{
    public function parse(array $data): ?AbstractName
    {
        $result = new Result(false);
        foreach ($data as $key => $value) {
            $entry = new RowValue($key, $value);
            foreach ($this->rules as $rule) {
                if (!(is_a($rule, RuleInterface::class, true))) {
                    continue;
                }
                $result->with((new $rule)->apply($entry));
                if ($result->isComplete()) {
                    break 2;
                }
            }
        }

        return $this->buildNameFromResult($result);
    }

    /**
     * @param string $format
     * @return class-string<RuleInterface>[]
     */
    public static function defaultRules(string $format): array
    {
        return match ($format) {
            GermanTypeName::class => [
                GermanKeyNameRule::class,
                EnglishKeyNameRule::class,
            ],
            default => [
                EnglishKeyNameRule::class,
            ],
        };
    }
}