<?php

namespace HeimrichHannot\SalutationCreator;

use HeimrichHannot\SalutationCreator\Context\Position;
use Symfony\Contracts\Translation\TranslatorInterface;

class SalutationCreator
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function generate(SalutationContext $context): string
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

        $prefixTitles = $this->buildString($prefixTitleList);
        $suffixTitles = $this->buildString($suffixTitleList);

        $parameters = [
            '%prefix_titles%' => $prefixTitles,
            '%suffix_titles%' => $suffixTitles,
            '%gender_name%' => $context->getGender()->build()->trans($this->translator),
            '%gender%' => $context->getGender()->getKey(),
            '%name%' => $context->getName()?->getFullName() ?? '',
            '%formal_name%' => $context->getName()?->getFormalName() ?? '',
            '%given_name%' => $context->getName()?->getGivenName() ?? '',
        ];

        return trim($this->translator->trans(
            $context->getTranslationFormat(),
            $parameters,
            $context->getTranslationDomain()
        ));
    }

    /**
     * @param array<SalutationPartInterface|array<SalutationPartInterface>> $array
     */
    private function buildString(array $array): string
    {
        $string = '';
        array_walk_recursive($array, function ($value) use (&$string) {
            /**
             * @var SalutationPartInterface $value
             */
            $string .= $value->build()->trans($this->translator);
        });

        return $string;
    }
}
