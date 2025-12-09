<?php

declare(strict_types=1);

use Contao\Rector\Set\ContaoLevelSetList;
use Contao\Rector\Set\ContaoSetList;
use Rector\Config\RectorConfig;
use Rector\Php84\Rector\Param\ExplicitNullableParamTypeRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',

    ])
    ->withPhpVersion(PhpVersion::PHP_84)
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
        ExplicitNullableParamTypeRector::class,
    ])

    ->withImportNames(
        importShortClasses: false,
        removeUnusedImports: true
    )
    ->withComposerBased(
        symfony: true,
    )
    ->withSets([
        LevelSetList::UP_TO_PHP_82,
    ])
;
