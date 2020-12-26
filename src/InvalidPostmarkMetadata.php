<?php namespace MinimalPhpPostmarkSdk;

use Throwable;

final class InvalidPostmarkMetadata extends MinimalPhpPostmarkSdkException
{
    private function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fieldKeyLengthCannotBeLongerThan20Characters(string $key, string $value): static
    {
        $length = strlen($key);
        
        return new static(
            "According to Postmark API specifications, the field key may not be longer than 20 characters. The key '{$key}' is {$length} characters long."
        );
    }
    
    public static function fieldValueLengthCannotBeLongerThan80Characters(string $key, string $value): static
    {
        $length = strlen($key);
        
        return new static(
            "According to Postmark API specifications, the field value may not be longer than 80 characters. The value '{$key}' is {$length} characters long."
        );
    }
}