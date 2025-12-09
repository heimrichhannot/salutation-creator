<?php

namespace HeimrichHannot\SalutationCreator\Helper;

use HeimrichHannot\SalutationCreator\Context\Title\AbstractTitle;
use HeimrichHannot\SalutationCreator\Context\Title\GermanDoctorTitle;
use HeimrichHannot\SalutationCreator\Context\Title\GermanProfessorTitle;
use HeimrichHannot\SalutationCreator\Context\Title\SuffixTitle;

class Titles
{
    public static function defaultMapping(): array
    {
        return [
            'dr' => [GermanDoctorTitle::class],
            'dr.' => [GermanDoctorTitle::class],
            'prof' => [GermanProfessorTitle::class],
            'prof.' => [GermanProfessorTitle::class],
            'mba' => [SuffixTitle::class, ['MBA']],
            'phd' => [SuffixTitle::class, ['PhD']],
            'jr' => [SuffixTitle::class, ['Jr.']],
            'jr.' => [SuffixTitle::class, ['Jr.']],
            'sr' => [SuffixTitle::class, ['Sr.']],
            'sr.' => [SuffixTitle::class, ['Sr.']],
            'll.m.' => [SuffixTitle::class, ['LL.M.']],
            'll.m' => [SuffixTitle::class, ['LL.M.']],
        ];
    }

    /**
     * @param string $value
     * @param array|null $mapping Override the default string title mapping
     * @return AbstractTitle[]
     */
    public static function fromString(string $value, ?array $mapping = null): array
    {
        if (!$value) {
            return [];
        }

        $mapping = $mapping ?? self::defaultMapping();

        $tokens = preg_split('/\s+/', trim($value)) ?: [];
        $titles = [];

        foreach ($tokens as $token) {
            $key = rtrim(mb_strtolower($token), '.');

            if (!isset($mapping[$key])) {
                continue;
            }

            if (!isset($mapping[$key][0]) || !($mapping[$key][0] instanceof AbstractTitle)) {
                continue;
            }

            $titles[] = new $mapping[$key][0](...($mapping[$key][1] ?? []));
        }

        return $titles;
    }
}