<?php


namespace AGerault\Blog\ServiceProviders;

use Swift_SmtpTransport;

class MailServiceProvider
{
    public static function make(string $host, int $port, string $username, string $password): Swift_SmtpTransport
    {
        return (new Swift_SmtpTransport($host, $port))
            ->setUsername($username)
            ->setPassword($password);
    }
}
