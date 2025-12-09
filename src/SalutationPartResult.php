<?php

namespace HeimrichHannot\SalutationCreator;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class SalutationPartResult implements TranslatableInterface, \Stringable
{
    public function __construct(
        private string  $message,
        private array   $parameters = [],
        private ?string $domain = null,
        private ?string $fallback = null,
        private bool    $doNotTranslate = false,
    ) {}

    public function __toString(): string
    {
        return $this->getMessage();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        if ($this->doNotTranslate) {
            return $this->getMessage();
        }

        $parameters = $this->getParameters();
        foreach ($parameters as $k => $v) {
            if ($v instanceof TranslatableInterface) {
                $parameters[$k] = $v->trans($translator, $locale);
            }
        }

        $result = $translator->trans($this->getMessage(), $parameters, $this->getDomain(), $locale);
        if (null !== $this->fallback && $result === $this->getMessage()) {
            return $this->fallback;
        }

        return $result;
    }
}