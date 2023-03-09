<?php

declare(strict_types=1);

namespace App\Domain\Auth\Service;

use App\Domain\Auth\Entity\User\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as Mailer;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class JoinConfirmationSender
{
    private MailerInterface $mailer;

    private Environment $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function send(Email $email, string $token): void
    {
        $content = $this->twig->render('mail/confirmation.html.twig', [
            'token' => $token,
        ]);

        $email = (new Mailer())
            ->to($email->getValue())
            ->subject('Подтверждение регистрации.')
            ->html($content);

        $this->mailer->send($email);
    }
}
