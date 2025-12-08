<?php

namespace HeimrichHannot\SalutationCreator\Context;

use HeimrichHannot\SalutationCreator\Context\Title\SuffixTitle;

class Title
{
    private const GERMAN_ACADEMIC_TITLES = [
        'dr' => 'Dr.',
        'dr.' => 'Dr.',
        'prof' => 'Prof.',
        'prof.' => 'Prof.',
        'prof. dr.' => 'Prof. Dr.',
    ];

    private const SUFFIX_TITLE_MAP = [
        'mba' => 'MBA',
        'phd' => 'PhD',
        'jr' => 'Jr.',
        'jr.' => 'Jr.',
        'sr' => 'Sr.',
        'sr.' => 'Sr.',
        'll.m.' => 'LL.M.',
        'll.m' => 'LL.M.',
    ];

    public static function parseString(string $value): array
    {
        if (!$value) {
            return [];
        }

        $tokens = preg_split('/\s+/', trim($value)) ?: [];
        $titles = [];

        foreach ($tokens as $token) {
            $key = rtrim(mb_strtolower($token), '.');

            if (isset(self::GERMAN_ACADEMIC_TITLES[$key])) {
                $titles[] = self::GERMAN_ACADEMIC_TITLES[$key];
                continue;
            }

            if (in_array($token, self::SUFFIX_TITLE_MAP)) {
                $titles[] = new SuffixTitle(self::SUFFIX_TITLE_MAP[$key]);
                continue;
            }
        }

        return $titles;
    }
}