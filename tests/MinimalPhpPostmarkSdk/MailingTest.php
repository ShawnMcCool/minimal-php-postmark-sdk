<?php namespace Tests\MinimalPhpPostmarkSdk;

use PHPUnit\Framework\TestCase;
use MinimalPhpPostmarkSdk\Mailing;
use MinimalPhpPostmarkSdk\Attachment;
use MinimalPhpPostmarkSdk\Email;

class MailingTest extends TestCase
{
    function testCanSerializeMailingsForThePostmarkApi()
    {
        $mailing = new Mailing(
            'fromName',
            Email::fromString('fromEmail@email.com'),
            Email::fromString('toEmail@email.com'),
            'subject line',
            'html body',
            [
                new Attachment(
                    'filename',
                    'text/plain',
                    'contents'
                ),
            ],
            'message-type-tag',
            [
                'key' => 'value',
                'key2' => 'value2'
            ],
            'template-alias',
            'template id',
            [
                'template value' => 'hats',
                'template calue' => 'cats',
                'template lalue' => 'lats'
            ]
        );
        
        $serialized = $mailing->serializeToApi();
        
        self::assertSame('fromName <fromEmail@email.com>', $serialized['From']);
        self::assertSame('toEmail@email.com', $serialized['To']);
        self::assertIsArray($serialized['Attachments']);
        self::assertCount(1, $serialized['Attachments']);
        self::assertSame('message-type-tag', $serialized['Tag']);
        self::assertSame('subject line', $serialized['Subject']);
        self::assertSame('html body', $serialized['HtmlBody']);
        self::assertIsArray($serialized['Metadata']);
        self::assertCount(2, $serialized['Metadata']);
        self::assertSame('template id', $serialized['TemplateId']);
        self::assertIsArray($serialized['TemplateModel']);
        self::assertCount(3, $serialized['TemplateModel']);
        self::assertSame('template id', $serialized['TemplateId']);
        self::assertSame('template-alias', $serialized['TemplateAlias']);
    }
}
