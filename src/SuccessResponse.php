<?php namespace MinimalPhpPostmarkSdk;

final class SuccessResponse
{
    public function __construct(
        private string $messageId,
        private EmailAddress $toEmail,
        private Timestamp $sentAt
    ) {
    }

    public function messageId(): string
    {
        return $this->messageId;
    }

    public function emailAddress(): EmailAddress
    {
        return $this->toEmail;
    }

    public function sentAt(): Timestamp
    {
        return $this->sentAt;
    }
}