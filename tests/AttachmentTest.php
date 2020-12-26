<?php namespace Tests;

use PHPUnit\Framework\TestCase;
use MinimalPhpPostmarkSdk\Attachment;

class AttachmentTest extends TestCase
{
    function testCanCreateFileAttachments()
    {
        $attachment = new Attachment(
            'filename.txt',
            'text/plain',
            'file contents'
        );

        self::assertSame('filename.txt', $attachment->name());
        self::assertSame('text/plain', $attachment->mimeType());
        self::assertSame('file contents', $attachment->contents());
    }

    function testCanBeSerializedToThePostmarkApiFormat()
    {
        $attachment = new Attachment(
            'filename.txt',
            'text/plain',
            'file contents'
        );

        $serialized = $attachment->serializeToApi();

        self::assertSame('filename.txt', $serialized->Name);
        self::assertSame('text/plain', $serialized->ContentType);
        self::assertSame('file contents', base64_decode($serialized->Content));
    }
}