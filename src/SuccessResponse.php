<?php namespace MinimalPhpPostmarkSdk;

final class SuccessResponse
{
    public function __construct(
        private string $messageId,
        private Email $toEmail,
        private Timestamp $sentAt
    ) {
    }

    public function messageId(): string
    {
        return $this->messageId;
    }

    public function toEmail(): Email
    {
        return $this->toEmail;
    }

    public function sentAt(): Timestamp
    {
        return $this->sentAt;
    }
}