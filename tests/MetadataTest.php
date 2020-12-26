<?php namespace Tests;

use PHPUnit\Framework\TestCase;
use MinimalPhpPostmarkSdk\Metadata;
use MinimalPhpPostmarkSdk\InvalidPostmarkMetadata;

class MetadataTest extends TestCase
{
    function testKeyLengthCannotBeLongerThan20Characters()
    {
        self::assertInstanceOf(
            Metadata::class,
            Metadata::fromKeyValue(str_repeat('-', 20), 'value')
        );

        $this->expectException(InvalidPostmarkMetadata::class);

        Metadata::fromKeyValue(str_repeat('-', 21), 'value');
    }

    function testValueLengthCannotBeLongerThan80Characters()
    {
        self::assertInstanceOf(
            Metadata::class,
            Metadata::fromKeyValue('key', str_repeat('-', 80))
        );

        $this->expectException(InvalidPostmarkMetadata::class);

        Metadata::fromKeyValue('key', str_repeat('-', 81));
    }
}
