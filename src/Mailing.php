<?php namespace MinimalPhpPostmarkSdk;

class Mailing
{
    public function __construct(
        private string $fromName,
        private Email $fromEmail,
        private Email $toEmail,
        private ?string $subject = null,
        private ?string $html = null,
        private array $attachments = [],
        private string $messageTypeTag = '',
        private array $metadata = [],
        private ?string $templateAlias = null,
        private ?string $templateId = null,
        private array $templateModel = []
    ) {
        $this->metadata = array_map(
            fn($key, $value) => Metadata::fromKeyValue($key, $value),
            array_keys($this->metadata), $this->metadata
        );
    }

    public function fromName(): string
    {
        return $this->fromName;
    }

    public function fromEmail(): Email
    {
        return $this->fromEmail;
    }

    public function toEmail(): Email
    {
        return $this->toEmail;
    }

    public function subject(): ?string
    {
        return $this->subject;
    }

    public function html(): ?string
    {
        return $this->html;
    }

    public function attachments(): array
    {
        return $this->attachments;
    }

    public function messageTypeTag(): string
    {
        return $this->messageTypeTag;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    public function templateId(): ?string
    {
        return $this->templateId;
    }

    public function templateAlias(): ?string
    {
        return $this->templateAlias;
    }

    public function templateModel(): array
    {
        return $this->templateModel;
    }

    public function isTemplateMail(): bool
    {
        return $this->templateId || $this->templateAlias;
    }

    public function serializeToApi(): array
    {
        $fields = [
            'From' => $this->fromName . ' <' . $this->fromEmail->toString() . '>',
            'To' => $this->toEmail->toString(),
            'Attachments' => array_map(
                fn(Attachment $attachment) => $attachment->serializeToApi(),
                $this->attachments
            ),
            'Tag' => $this->messageTypeTag,
        ];

        if ($this->subject) {
            $fields['Subject'] = $this->subject;
        }

        if ($this->html) {
            $fields['HtmlBody'] = $this->html;
        }

        if ( ! empty($this->metadata)) {
            $fields['Metadata'] = array_merge(
                array_map(
                    fn(Metadata $metadatum) => [$metadatum->key() => $metadatum->value()],
                    $this->metadata
                )
            );
        }

        if ($this->templateId) {
            $fields['TemplateId'] = $this->templateId;
            $fields['TemplateModel'] = $this->templateModel;
        }

        if ($this->templateAlias) {
            $fields['TemplateAlias'] = $this->templateAlias;
            $fields['TemplateModel'] = $this->templateModel;
        }
        
        return $fields;
    }
}