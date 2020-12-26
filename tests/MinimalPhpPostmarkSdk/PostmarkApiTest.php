<?php namespace Tests\MinimalPhpPostmarkSdk;

use PHPUnit\Framework\TestCase;
use MinimalPhpPostmarkSdk\PostmarkApi;

class PostmarkApiTest extends TestCase
{
    function testPostmarkApiCanBeInstantiated()
    {
        self::assertInstanceOf(PostmarkApi::class, new PostmarkApi('token'));
    }
}
