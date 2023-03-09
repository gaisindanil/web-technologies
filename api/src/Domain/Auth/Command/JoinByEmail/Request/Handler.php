<?php

declare(strict_types=1);

namespace App\Domain\Auth\Command\JoinByEmail\Request;

use App\Domain\Auth\Entity\User\Email;
use App\Domain\Auth\Entity\User\FullName;
use App\Domain\Auth\Entity\User\Role;
use App\Domain\Auth\Entity\User\Status;
use App\Domain\Auth\Entity\User\User;
use App\Domain\Auth\Entity\User\UserRepository;
use App\Domain\Auth\Service\ConfirmTokenGenerator;
use App\Domain\Auth\Service\JoinConfirmationSender;
use App\Domain\Auth\Service\PasswordHashGenerator;
use App\Domain\Common\Types\Id;
use App\Domain\Flusher;
use DateTimeImmutable;
use DomainException;
use Exception;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class Handler
{
    private UserRepository $userRepository;
    private ConfirmTokenGenerator $confirmTokenGenerator;
    private PasswordHashGenerator $passwordHashGenerator;
    private Flusher $flusher;
    private JoinConfirmationSender $joinConfirmationSender;

    public function __construct(
        UserRepository $userRepository,
        ConfirmTokenGenerator $confirmTokenGenerator,
        PasswordHashGenerator $passwordHashGenerator,
        Flusher $flusher,
        JoinConfirmationSender $joinConfirmationSender
    ) {
        $this->userRepository = $userRepository;
        $this->confirmTokenGenerator = $confirmTokenGenerator;
        $this->passwordHashGenerator = $passwordHashGenerator;
        $this->flusher = $flusher;
        $this->joinConfirmationSender = $joinConfirmationSender;
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        if ($command->password !== $command->confirmPassword) {
            throw new DomainException('Пароли не совпадают.');
        }

        $email = new Email($command->email);

        if ($this->userRepository->hasByEmail($email)) {
            throw new DomainException('Пользователь уже существует.');
        }

        $user = new User(
            Id::next(),
            new FullName(
                $command->firstName,
                $command->lastName,
                $command->middleName
            ),
            Status::wait(),
            $email,
            Role::user(),
            $this->passwordHashGenerator->hash($command->password),
            new DateTimeImmutable(),
            $token = $this->confirmTokenGenerator->generate()
        );

        $this->userRepository->add($user);

        $this->flusher->flush();

        $this->joinConfirmationSender->send($email, $token);
    }
}
