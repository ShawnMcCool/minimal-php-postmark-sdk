<?php namespace MinimalPhpPostmarkSdk;

final class ErrorResponse
{
    public function __construct(
        private string $errorCode,
        private string $errorMessage
    ) {
    }

    public function errorCode(): string
    {
        return $this->errorCode;
    }

    public function errorMessage(): string
    {
        return $this->errorMessage;
    }
}