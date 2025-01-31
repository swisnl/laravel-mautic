<?php

namespace Swis\Laravel\Mautic\Notifications;

class MauticMessage
{
    private int|string $contact;

    private array $tokens = [];

    public function __construct(private readonly int|string $mailId) {}

    public static function create(int|string $mailId): self
    {
        return new self($mailId);
    }

    public function getMailId(): int|string
    {
        return $this->mailId;
    }

    public function tokens(array $tokens): self
    {
        $this->tokens = $tokens;

        return $this;
    }

    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function to(int|string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getTo(): int|string|null
    {
        return $this->contact ?? null;
    }
}
