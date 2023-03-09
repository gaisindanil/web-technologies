<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ResetController extends AbstractController
{
    #[Route('/reset-password-request', name: 'reset.password.request')]
    public function index(): Response
    {
        return $this->render('app/auth/reset.html.twig');
    }

    #[Route('/reset-password-confirm', name: 'reset.password.confirm')]
    public function confirm(): Response
    {
        return $this->render('app/auth/confirm.html.twig');
    }
}
