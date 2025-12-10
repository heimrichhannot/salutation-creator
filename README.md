# Salutation Creator

![](https://img.shields.io/badge/PHPStan-level%2010-brightgreen.svg?style=flat)


A PHP library for creating personalized salutations for different contexts with support for titles, gender, and multilingual translations.

## Installation

```bash
composer require heimrichhannot/salutation-creator
```

## Requirements

- PHP ^8.1
- symfony/translation-contracts ^1 || ^2 || ^3

## Features

- ✅ Flexible salutation generation (formal/informal)
- ✅ Support for academic titles (Dr., Prof., etc.)
- ✅ Gender-sensitive salutations
- ✅ Prefix and suffix titles with priorities
- ✅ Multilingual translations via Symfony Translation
- ✅ Extensible with custom name, gender, and title classes

## Basic Usage

Basic example:

```php
use HeimrichHannot\SalutationCreator\SalutationCreator;
use HeimrichHannot\SalutationCreator\SalutationContext;
use HeimrichHannot\SalutationCreator\Context\Name\GermanTypeName;
use HeimrichHannot\SalutationCreator\Context\Gender\Gender;

$salutationCreator = new SalutationCreator($translator);

$context = (new SalutationContext())
    ->setName(new GermanTypeName('Max', 'Mustermann'))
    ->setGender(Gender::MALE);

echo $salutationCreator->generate($context);
// Output: "Sehr geehrter Herr Mustermann"
```

With (academic) Titles:

```php
use HeimrichHannot\SalutationCreator\Context\Title\GermanDoctorTitle;
use HeimrichHannot\SalutationCreator\Context\Title\GermanProfessorTitle;
use HeimrichHannot\SalutationCreator\Context\Title\PrefixTitle;
use HeimrichHannot\SalutationCreator\Helper\Titles;

$context = (new SalutationContext())
    ->setName(new GermanTypeName('Anna', 'Schmidt'))
    ->setGender(Gender::FEMALE)
    ->addTitle(new GermanDoctorTitle())
    ->addTitle(new GermanProfessorTitle())
    ->addTitle(new PrefixTitle('Hero')
    ->addTitles(Titles::fromString('dr phd unknown')); // Adding titles from string
    ;
    

echo $salutationCreator->generate($context);
// Output: "Sehr geehrte Frau Prof. Dr. Hero Dr. Schmidt PhD."
```

Custom translation key (e.g. informal salutation):

```php
$context = (new SalutationContext())
    ->setName(new GermanTypeName('Lisa', 'Müller'))
    ->setTranslationConfig('format.informal');

echo $salutationCreator->generate($context);
// Output: "Hallo Lisa"
```

Gender from string:

```php
use HeimrichHannot\SalutationCreator\SalutationCreator;
use HeimrichHannot\SalutationCreator\SalutationContext;
use HeimrichHannot\SalutationCreator\Context\Gender\Gender;

$data = [
    'firstname' => 'Lisa',
    'lastname' => 'Müller',
    'gender' => 'female',
];

$salutationContext = (new SalutationContext())
    ->setName(new GermanTypeName($data['firstname'], $data['lastname']))
    ->addTitles(Gender::tryFromString($data['gender'])));

echo (new SalutationCreator($this->translator))->generate($salutationContext);
// Outputs "Sehr geehrte Frau Müller"
```

## Translations / Translation files

Since this library in framework-agnostic, you need to register the translation files manually or copy them to your project's translation directory.
You'll find translation files in the symfony translation ICU format in the `translations` directory of this package.

### Register Translation Files with Symfony

In your `config/packages/framework.yaml`:

```yaml
framework:
  translator:
    paths:
      - '%kernel.project_dir%/vendor/heimrichhannot/salutation-creator/translations'
```

### Usage in a Controller

```php
use HeimrichHannot\SalutationCreator\SalutationCreator;
use HeimrichHannot\SalutationCreator\SalutationContext;
use HeimrichHannot\SalutationCreator\Context\Name\GermanTypeName;
use Symfony\Contracts\Translation\TranslatorInterface;

class MessageController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {}

    public function sendMessage($firstName, $lastName): string
    {
        $salutation = (new SalutationCreator($this->translator))
            ->generate(
                (new SalutationContext())
                    ->setName(new GermanTypeName($firstName, $lastName))
            );
        
        return $salutation;
    }
}
```

### Custom Translations

Create a translation file `translations/salutation_creator+intl-icu.{locale}.yaml`:

```yaml
format.formal: >
  {gender, select,
    m {Sehr geehrter {gender_name} {prefix_titles} {formal_name} {suffix_titles}}
    w {Sehr geehrte {gender_name} {prefix_titles} {formal_name} {suffix_titles}}
    nb {Sehr geehrte*r {gender_name} {prefix_titles} {formal_name} {suffix_titles}}
    other {Sehr geehrter {gender_name} {prefix_titles} {formal_name} {suffix_titles}}
  }
format.informal: 'Hallo {given_name}'

gender.m: 'Herr'
gender.f: 'Frau'
gender.d: ''
gender.nb: ''

title.german_doctor: 'Dr.'
title.german_professor: 'Prof.'
```

**Note:** The example and the bundles translation files follow the [Symfony ICU MessageFormat](https://symfony.com/doc/current/translation/message_format.html), 
which supports the `select` syntax for conditional translations based on variables like gender. This allows for flexible, gender-sensitive formatting.

### Use custom translation keys and domain

```php
$context->setTranslationConfig(
    formatKey: 'my_custom.format',
    domain: 'my_domain'
);
```

### Available format parameters

The following parameters are available in translations:

- `%prefix_titles%` - All titles before the name
- `%suffix_titles%` - All titles after the name
- `%gender_name%` - Gender designation (Mr./Ms.)
- `%gender%` - Gender abbreviation (m/f/d)
- `%name%` - Full name
- `%formal_name%` - Formal name (usually last name)
- `%given_name%` - First name


## Available (bundled) Classes

### Name Classes

- `GermanTypeName`: German names with first and last name

### Gender

- `Gender::MALE` - Male
- `Gender::FEMALE` - Female
- `Gender::DIVERSE` - Diverse

### Title Classes

- `GermanDoctorTitle`: Doctor title (Dr.)
- `GermanProfessorTitle`: Professor title (Prof.)
- `PrefixTitle`: Custom title before the name
- `SuffixTitle`: Custom title after the name

### Custom Titles

```php
use HeimrichHannot\SalutationCreator\Context\Title\PrefixTitle;

$context->addTitle(new PrefixTitle(
    message: 'Dr. med.',
    priority: 5
));
```

## Customization and Extension

### Create Custom Gender

You can create custom gender classes by implementing the `GenderInterface`:

```php
use HeimrichHannot\SalutationCreator\Context\Gender\GenderInterface;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

enum CustomGender: string implements GenderInterface
{
    case NON_BINARY = 'nb';
    case PREFER_NOT_TO_SAY = 'x';

    public function build(): SalutationPartResult
    {
        return new SalutationPartResult(
            'gender.' . $this->value,
            domain: 'my_custom_domain',
            fallback: ucfirst($this->value),
        );
    }

    public function getKey(): string
    {
        return $this->value;
    }
}
```

### Create Custom Title Class

You can create custom title classes by extending `AbstractTitle`:

```php
use HeimrichHannot\SalutationCreator\Context\Title\AbstractTitle;
use HeimrichHannot\SalutationCreator\Context\Position;
use HeimrichHannot\SalutationCreator\SalutationPartResult;

class CustomTitle extends AbstractTitle
{
    public function build(): SalutationPartResult
    {
        return new SalutationPartResult(
            message: 'title.custom',
            domain: 'my_custom_domain',
            fallback: 'Custom Title'
        );
    }

    public function getPosition(): Position
    {
        return Position::PREFIX;
    }

    public function getPriority(): int
    {
        return 10; // Higher priority = appears first
    }
}
```

### Create Custom Name Class

```php
use HeimrichHannot\SalutationCreator\Context\Name\AbstractName;

class IcelandTypeName extends AbstractName
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName
    ) {}

    public function getFullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getFormalName(): string
    {
        return $this->firstName;
    }

    public function getGivenName(): string
    {
        return $this->firstName;
    }
}
```