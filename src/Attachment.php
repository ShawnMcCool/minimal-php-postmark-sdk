<?php namespace MinimalPhpPostmarkSdk;

use JetBrains\PhpStorm\ArrayShape;

class Attachment
{
    public function __construct(
        private string $name,
        private string $mimeType,
        private string $contents
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function mimeType(): string
    {
        return $this->mimeType;
    }

    public function contents(): string
    {
        return $this->contents;
    }

    #[ArrayShape(['Name' => "string", 'Content' => "string", 'ContentType' => "string"])]
    public function serializeToApi(): array
    {
        return [
            'Name' => $this->name,
            'Content' => base64_encode($this->contents),
            'ContentType' => $this->mimeType,
        ];
    }
}