<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Domain\Auth\Command\JoinByEmail;
use DomainException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SignUpController extends AbstractController
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Route('/sign-up', name: 'signUp')]
    public function index(Request $request, JoinByEmail\Request\Handler $handler): Response
    {
        $command = new JoinByEmail\Request\Command();

        $form = $this->createForm(JoinByEmail\Request\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->redirectToRoute('app_login');
                $this->addFlash('success', 'На адрес электронный почты отправлено письмо. Перейдите по ссылке, указанной в письме и подтвердите свой электронный адрес.');
                return $this->redirectToRoute('app_login');
            } catch (DomainException $e) {
                $this->logger->error($err = $e->getMessage());
                $this->addFlash('error', $err);
            }
        }

        return $this->render('app/auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/sign-up-confirm/{token}', name: 'sign_up_confirm')]
    public function confirm(string $token, JoinByEmail\Confirm\Handler $handler): Response
    {
        try {
            $handler->handle(new JoinByEmail\Confirm\Command($token));
            $this->addFlash('success', 'Аккаунт подтвержден.');
        } catch (DomainException $e) {
            $this->logger->error($err = $e->getMessage());
            $this->addFlash('error', $err);
        }
        return $this->redirectToRoute('app_login');
    }
}
