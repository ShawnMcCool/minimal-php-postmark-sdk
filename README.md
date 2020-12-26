# Minimal PHP Postmark SDK

A minimal PHP Postmark SDK that enables you to send single and batched email through the PostmarkApp.com service.

## Install

```shell
$ composer require shawnmccool/minimal-php-postmark-sdk
```

## Creating Mailings

The Mailing class represents a single instance that will be sent to a single recipient.

### Simple Mail

To, from, subject, and body.

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email};

new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    'subject line',
    'email body'
);
```

### Tags and Metadata

Configure message tags and metadata for link each mailing to entities, events, etc.

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email};

new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    'subject line',
    'email body',
    [],
    'holiday-sales-campaign',
    [
        'user_id' => 1,
        'description' => 'this information may be maximum 80 characters'
    ]
);
```

### File Attachments

Multiple files can be attached.

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email, Attachment};

new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    'subject line',
    'email body',
    [
        new Attachment(
            'filename.pdf',
            'application/pdf',
            file_get_contents('local.pdf')
        )
    ]
);
```

### Postmark Templates

Instead of specifying a subject line and html body you can use the Postmark template feature. Build the template in the Postmark user interface and specify either its id or alias in the mailing.

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email};

new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    null, null, [], '', [],
    'postmark template alias'
);
```

or

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email};

new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    null, null, [], '', [], '',
    'template id'
);
```

Postmark templates allow for variables. Create a template model to fill those variables.

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email};

new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    null, null, [], '', [], '',
    'template id',
    [
        'customer_name' => 'Roger',
        'product_name' => 'A really fun gift.'
    ]
);
```

### Named Parameters

There's a number of options when creating a mailing. It could be possible to make a more rich and complex object model to reduce the need for optional constructor arguments. But in the name of simplicity and the fact that the class is
feature complete we're going to leave it how it is.

If you don't like the empty arguments you can create a wrapper class, or you might prefer to use named parameters.

```php
<?php

use MinimalPhpPostmarkSdk\{Mailing, Email};

new Mailing(
    fromName: 'from name',
    fromEmail: Email::fromString('from@email.com'),
    toEmail: Email::fromString('to@email.com'),
    templateId: 'template id',
    templateModel: [
        'customer_name' => 'Roger',
        'product_name' => 'A really fun gift.'
    ]
);
```

## Send the Mailing

### Interacting with the Postmark API

You'll need a server token from postmark.

The `PostmarkApi` class handles interactions with the Postmark API.

```php
<?php

use MinimalPhpPostmarkSdk\PostmarkApi;

$postmark = new PostmarkApi('server token');
```

### Send a Single Mailing

Sending a single mail is different from sending a batch. The response is an instance of `SuccessResponse` or `ErrorResponse`.

```php
use MinimalPhpPostmarkSdk\{PostmarkApi,Mailing,Email,SuccessResponse};

$mailing = new Mailing(
    'from name',
    Email::fromString('from@email.com'),
    Email::fromString('to@email.com'),
    null, null, [], '', [], '',
    'template id'
);

$response = (new PostmarkApi('server token'))->single($mailing);

if ($response instanceof SuccessResponse) {
    echo $response->messageId();
} else {
    echo $response->errorMessage();
}
```

### Send a Batch Mailing

A batched mailing is an array of mailings that will be sent to the Postmark api in chunks. This prevents new connections to the api being made for each and every mailing. By default the batch mailing will send chunks of 500 mailings at
once; but this can be configured.

```php
use MinimalPhpPostmarkSdk\{PostmarkApi,Mailing,Email};

$mailings = [
    new Mailing(
        'from name',
        Email::fromString('from@email.com'),
        Email::fromString('to@email.com'),
        null, null, [], '', [], '',
        'template id'
    ),
    new Mailing(
        'from name',
        Email::fromString('from@email.com'),
        Email::fromString('to@email.com'),
        null, null, [], '', [], '',
        'template id'
    )
];

# to send a batch with default settings
(new PostmarkApi('server token'))->batch($mailings);

# manually specify chunk size {how many mailings to send in one call)
(new PostmarkApi('server token'))->batch($mailings, 100);
```