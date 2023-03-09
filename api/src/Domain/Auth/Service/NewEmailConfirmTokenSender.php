<?php

declare(strict_types=1);

namespace App\Domain\Auth\Service;

use App\Domain\Auth\Entity\User\Email;
use App\Domain\Auth\Entity\User\FullName;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as Mailer;
use Twig\Environment;

final class NewEmailConfirmTokenSender
{
    private Environment $twig;

    private MailerInterface $mailer;

    public function __construct(Environment $twig, MailerInterface $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function send(Email $email, string $token, FullName $fullName): void
    {
        $content = $this->twig->render('mail/confirmation.html.twig', [
            'name' => $fullName,
            'token' => $token,
        ]);

        $email = (new Mailer())
            ->to($email->getValue())
            ->subject('Подтверждение регистрации.')
            ->html($content);

        $this->mailer->send($email);
    }
}
