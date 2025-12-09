<?php

namespace HeimrichHannot\SalutationCreator\Helper;

use HeimrichHannot\SalutationCreator\Context\Title\AbstractTitle;
use HeimrichHannot\SalutationCreator\Context\Title\GermanDoctorTitle;
use HeimrichHannot\SalutationCreator\Context\Title\GermanProfessorTitle;
use HeimrichHannot\SalutationCreator\Context\Title\SuffixTitle;

class Titles
{
    public static function defaultMap(): array
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
     * @param array|null $map Override the default string title mapping
     * @return AbstractTitle[]
     */
    public static function fromString(string $value, ?array $map = null): array
    {
        if (!$value) {
            return [];
        }

        $map = $map ?? self::defaultMap();

        $tokens = preg_split('/\s+/', trim($value)) ?: [];
        $titles = [];

        foreach ($tokens as $token) {
            $key = rtrim(mb_strtolower($token), '.');

            if (!isset($map[$key])) {
                continue;
            }

            if (!isset($map[$key][0]) || !($map[$key][0] instanceof AbstractTitle)) {
                continue;
            }

            $titles[] = new $map[$key][0](...($map[$key][1] ?? []));
        }

        return $titles;
    }
}