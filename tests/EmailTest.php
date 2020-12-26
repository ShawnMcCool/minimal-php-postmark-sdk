<?php namespace Tests;

use PHPUnit\Framework\TestCase;
use MinimalPhpPostmarkSdk\Email;
use MinimalPhpPostmarkSdk\EmailAddressIsNotValid;

class EmailTest extends TestCase
{
    function testCanBeValidEmailAddresses()
    {
        self::assertInstanceOf(Email::class, Email::fromString('test@email.com'));
    }

    function testCantBeAnInvalidEmailAddress()
    {
        $this->expectException(EmailAddressIsNotValid::class);
        Email::fromString('not a valid email address');
    }
}
