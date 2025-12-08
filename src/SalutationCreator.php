<?php

namespace HeimrichHannot\SalutationCreator;

use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\Context\Title\AbstractTitle;
use Symfony\Contracts\Translation\TranslatorInterface;

class SalutationCreator
{
    public function generate(TranslatorInterface $translator, SalutationContext $context): string
    {
        $prefixTitleList = [];
        $suffixTitleList = [];
        foreach ($context->getTitles() as $title) {
            if (Position::PREFIX === $title->getPosition()) {
                $prefixTitleList[$title->getPriority()][] = $title;
                continue;
            } else {
                $suffixTitleList[$title->getPriority()][] = $title;
            }
        }

        $prefixTitles = $this->buildString($prefixTitleList, $translator);
        $suffixTitles = $this->buildString($suffixTitleList, $translator);

        $parameters = [
            '%prefix_titles%' => $prefixTitles,
            '%suffix_titles%' => $suffixTitles,
            '%gender%' => $context->getGender()->build()->trans($translator),
            '%name%' => $context->getName()->getFullName(),
            '%formal_name%' => $context->getName()->getFormalName(),
            '%given_name%' => $context->getName()->getGivenName(),
        ];

        return $translator->trans(
            $context->getTranslationFormat(),
            $parameters,
            $context->getTranslationDomain()
        );

    }

    private function buildString(array $array, TranslatorInterface $translator): string
    {
        $string = '';
        array_walk_recursive($array, function ($value) use (&$string, $translator) {
            /**
             * @var AbstractTitle $value
             */
            $string .= $value->build()->trans($translator);
        });

        return $string;
    }
}