<?php

declare(strict_types=1);

namespace App\DataFixtures\User;

use App\Domain\Auth\Entity\User\Email;
use App\Domain\Auth\Entity\User\FullName;
use App\Domain\Auth\Entity\User\Role;
use App\Domain\Auth\Entity\User\Status;
use App\Domain\Auth\Entity\User\User;
use App\Domain\Auth\Entity\User\UserRepository;
use App\Domain\Auth\Service\PasswordHashGenerator;
use App\Domain\Common\Types\Id;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

final class UserFixtures extends Fixture
{
    private const LOCALE = 'ru_RU';

    private const USER_PUBLIC_ID = '3c35c44e-c36f-41dd-a33a-d60c26f12d6a';

    private PasswordHashGenerator $passwordHashGenerator;

    private UserRepository $userRepository;

    public function __construct(
        PasswordHashGenerator $passwordHashGenerator,
        UserRepository $userRepository,
    ) {
        $this->passwordHashGenerator = $passwordHashGenerator;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create(self::LOCALE);

        $fullName = new FullName(
            $faker->firstName,
            $faker->lastName,
            $faker->firstName
        );

        $user = new User(
            new Id(self::USER_PUBLIC_ID),
            $fullName,
            Status::active(),
            new Email('admin@elpod.tech'),
            Role::admin(),
            $this->passwordHashGenerator->hash('123456'),
            new DateTimeImmutable(),
            ''
        );

        $this->userRepository->add($user);

        $manager->flush();
    }
}
