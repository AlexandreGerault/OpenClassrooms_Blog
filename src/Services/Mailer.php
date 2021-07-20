<?php

namespace AGerault\Blog\Services;

use AGerault\Blog\Contracts\Services\MailerInterface;
use Swift_Mailer;
use Swift_Message;

final class Mailer implements MailerInterface
{
    private string $text = "";
    private string $html = "";
    private string $to = "";
    private string $from = "";
    private string $subject = "";

    public function __construct(protected Swift_Mailer $mailer) {}

    public function text(string $text): MailerInterface
    {
        $this->text = $text;
        return $this;
    }

    public function html(string $html): MailerInterface
    {
        $this->html = $html;

        return $this;
    }

    public function to(string $to): MailerInterface
    {
        $this->to = $to;

        return $this;
    }

    public function from(string $from): MailerInterface
    {
        $this->from = $from;

        return $this;
    }

    public function subject(string $subject): MailerInterface
    {
        $this->subject = $subject;

        return $this;
    }

    public function send(): void
    {
        $message = (new Swift_Message($this->subject))
            ->setSubject($this->subject)
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody($this->text);

        $this->mailer->send($message);
    }
}
