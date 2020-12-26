<?php namespace MinimalPhpPostmarkSdk;

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

    public function serializeToApi(): object
    {
        return (object) [
            'Name' => $this->name,
            'Content' => base64_encode($this->contents),
            'ContentType' => $this->mimeType,
        ];
    }
}