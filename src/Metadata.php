<?php namespace MinimalPhpPostmarkSdk;

final class Metadata
{
    public function __construct(
        private string $key,
        private string $value
    ) {
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromKeyValue(
        string $key,
        string $value
    ): static {
        if (strlen($key) > 20) {
            throw InvalidPostmarkMetadata::fieldKeyLengthCannotBeLongerThan20Characters($key, $value);
        }

        if (strlen($value) > 80) {
            throw InvalidPostmarkMetadata::fieldValueLengthCannotBeLongerThan80Characters($key, $value);
        }

        return new static($key, $value);
    }
}