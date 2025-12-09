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

    public static function defaultMapping(): array
    {
        return [
            // male
            'male' => self::MALE,
            'men' => self::MALE,
            'männlich' => self::MALE,
            'herr' => self::MALE,
            // female
            'female' => self::FEMALE,
            'women' => self::FEMALE,
            'weiblich' => self::FEMALE,
            'w' => self::FEMALE,
            'frau' => self::FEMALE,
            // diverse
            'other' => self::DIVERSE,
            'diverse' => self::DIVERSE,
            'divers' => self::DIVERSE,
            'x' => self::DIVERSE,
        ];
    }

    public static function tryFromString(string $value, ?self $fallback = null, ?array $mapping = null): ?GenderInterface
    {
        $value = strtolower(trim($value));

        if ($result = self::tryFrom($value)) {
            return $result;
        }

        $mapping = $mapping ?? self::defaultMapping();

        return $mapping[$value] ?? $fallback;
    }
}
