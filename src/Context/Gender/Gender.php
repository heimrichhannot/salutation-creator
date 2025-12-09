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

    public static function tryFromString(string $value, ?self $fallback = null): ?GenderInterface
    {
        $value = strtolower(trim($value));

        if ($result = self::tryFrom($value)) {
            return $result;
        }

        if (in_array($value, ['male', 'männlich', 'herr'])) {
            return self::MALE;
        }

        if (in_array($value, ['female', 'weiblich', 'frau'])) {
            return self::FEMALE;
        }

        if (in_array($value, ['other', 'diverse', 'divers', 'x'])) {
            return self::DIVERSE;
        }

        return $fallback;
    }
}
