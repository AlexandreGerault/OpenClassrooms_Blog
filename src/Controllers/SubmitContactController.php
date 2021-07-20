<?php

namespace AGerault\Blog\Controllers;

use AGerault\Blog\Contracts\Services\MailerInterface;
use AGerault\Blog\Validators\ContactValidator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class SubmitContactController extends BaseController
{
    public function __construct(protected Environment $twig, protected MailerInterface $mailer) {}

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $validator = new ContactValidator($request->getParsedBody());

        if ( ! $validator->isValid()) {
            $this->render('homepage.html.twig', ['errors' => $validator->errors()]);
        }

        $inputs = $validator->validated();

        $content = "Message de {$inputs['first_name']} {$inputs['last_name']} <{$inputs['email']}>\n";
        $content .= $inputs['message'];

        $this
            ->mailer
            ->from('alexandre@hexium.io')
            ->to('alexandre@hexium.io')
            ->text($content)
            ->html(nl2br($content))
            ->send();

        return $this->redirect("/");
    }
}
