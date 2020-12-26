<?php namespace Tests;

use PHPUnit\Framework\TestCase;
use MinimalPhpPostmarkSdk\EmailAddress;
use MinimalPhpPostmarkSdk\EmailAddressIsNotValid;

class EmailAddressTest extends TestCase
{
    function testCanBeValidEmailAddresses()
    {
        self::assertInstanceOf(EmailAddress::class, EmailAddress::fromString('test@email.com'));
    }

    function testCantBeAnInvalidEmailAddress()
    {
        $this->expectException(EmailAddressIsNotValid::class);
        EmailAddress::fromString('not a valid email address');
    }
}
