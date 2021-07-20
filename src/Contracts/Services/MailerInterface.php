<?php

namespace AGerault\Blog\Contracts\Services;

interface MailerInterface
{
    public function text(string $text): self;

    public function html(string $html): self;

    public function to(string $to): self;

    public function from(string $from): self;

    public function subject(string $subject): self;

    public function send(): void;
}
