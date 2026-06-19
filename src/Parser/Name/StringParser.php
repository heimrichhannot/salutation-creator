<?php

namespace HeimrichHannot\SalutationCreator\Parser\Name;

use HeimrichHannot\SalutationCreator\Context\Name\AbstractName;
use HeimrichHannot\SalutationCreator\Parser\Name\Rule\Result;

class StringParser extends AbstractParser
{
    public static function defaultRules(string $format): array
    {
        return [];
    }

    /**
     * @todo Refactor this method to rule based parsing
     */
    public function parse(string $name): ?AbstractName
    {
        $name = preg_replace('/\s+/u', ' ', trim($name));
        if (empty($name)) {
            return null;
        }

        if (str_contains($name, ',')) {
            [$lastName, $firstName] = array_map('trim', explode(',', $name, 2));
            return $this->buildNameFromResult(new Result(true, $firstName, $lastName));
        }

        $parts = preg_split('/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
        $count = count($parts);

        if ($count === 1) {
            return $this->buildNameFromResult(new Result(true, '', $parts[0]));
        }

        if ($count === 2) {
            return $this->buildNameFromResult(new Result(true, $parts[0], $parts[1]));
        }

        $surnamePrefixes = [
            'von',
            'vom',
            'van',
            'de',
            'del',
            'della',
            'der',
            'den',
            'zu',
            'zur',
            'zum',
            'da',
            'di',
            'du',
            'la',
            'le',
            'dos',
            'das',
            'do',
            'bin',
            'al',
        ];

        // Startpunkt des Nachnamens suchen
        $lastNameStartIndex = $count - 1;

        while (
            $lastNameStartIndex > 0
            && in_array(mb_strtolower($parts[$lastNameStartIndex - 1]), $surnamePrefixes, true)
        ) {
            $lastNameStartIndex--;
        }

        if ($lastNameStartIndex < $count - 1) {
            return $this->buildNameFromResult(
                new Result(
                    true,
                    implode(' ', array_slice($parts, 0, $lastNameStartIndex)),
                    implode(' ', array_slice($parts, $lastNameStartIndex)),
                )
            );
        }

        // at least we have only wild guessing :)
        $splitIndex = (int) ceil($count / 2);
        return $this->buildNameFromResult(
            new Result(
                true,
                implode(' ', array_slice($parts, 0, $splitIndex)),
                implode(' ', array_slice($parts, $splitIndex))
            )
        );
    }
}