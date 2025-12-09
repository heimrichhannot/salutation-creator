<?php

namespace HeimrichHannot\SalutationCreator;

use HeimrichHannot\SalutationCreator\Context\Gender;
use HeimrichHannot\SalutationCreator\Context\Name\AbstractName;
use HeimrichHannot\SalutationCreator\Context\Title\AbstractTitle;

class SalutationContext
{
    public const TRANSLATION_DEFAULT_FORMAT_KEY = 'format.formal';
    public const TRANSLATION_DEFAULT_DOMAIN = 'salutation_creator';

    /**
     * @var AbstractTitle[]
     */
    private array $titles = [];
    private Gender $gender = Gender::DIVERSE;
    private ?AbstractName $name = null;

    private string $translationFormat = self::TRANSLATION_DEFAULT_FORMAT_KEY;
    private string $translationDomain = self::TRANSLATION_DEFAULT_FORMAT_KEY;

    public function hasTitle(): bool
    {
        return !empty($this->titles);
    }

    /**
     * @return AbstractTitle[]
     */
    public function getTitles(): array
    {
        return $this->titles;
    }

    public function addTitle(AbstractTitle $title): self
    {
        $this->titles[] = $title;

        return $this;
    }

    public function addTitles(array $titles): self
    {
        foreach ($titles as $title) {
            if ($title instanceof AbstractTitle) {
                $this->addTitle($title);
            }
        }

        return $this;
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getTranslationFormat(): string
    {
        return $this->translationFormat;
    }

    public function getTranslationDomain(): string
    {
        return $this->translationDomain;
    }

    public function setTranslationConfig(
        string $formatKey = self::TRANSLATION_DEFAULT_FORMAT_KEY,
        string $domain = self::TRANSLATION_DEFAULT_DOMAIN,
    ): self
    {
        $this->translationFormat = $formatKey;
        $this->translationDomain = $domain;

        return $this;
    }

    public function getName(): ?AbstractName
    {
        return $this->name;
    }

    public function setName(?AbstractName $name): self
    {
        $this->name = $name;

        return $this;
    }
}