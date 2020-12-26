<?php namespace MinimalPhpPostmarkSdk;

class Email
{
    private function __construct(
        private string $address
    ) {
        if ( ! filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new EmailAddressIsNotValid($address);
        }
    }

    public function toString(): string
    {
        return $this->address;
    }

    function equals(Email $that): bool
    {
        return $this->address == $that->address;
    }

    function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $address): static
    {
        return new static($address);
    }
}