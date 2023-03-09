<?php

declare(strict_types=1);

namespace App\Domain\Auth\Query\User\FindById;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class Fetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function fetch(Query $query): ?User
    {
        $result = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'public_id',
                'email',
                'created_at',
                'status',
                'password_hash',
                'role',
                'full_name_first_name',
                'full_name_last_name',
                'full_name_middle_name',
                'profile_id',
            ])
            ->from('users')
            ->where('id = :id')
            ->setParameter('id', $query->getId())
            ->executeQuery();

        /**
         * @var array{
         * id: int,
         * public_id: string,
         * email: string,
         * created_at: string,
         * status: string,
         * password_hash: string,
         * role: string,
         * full_name_first_name: string,
         * full_name_last_name: string,
         * full_name_middle_name: string,
         * profile_id: int
         * } | false $row
         */
        $row = $result->fetchAssociative();
        if (!$row) {
            return null;
        }

        return new User(
            id: $row['id'],
            publicId: $row['public_id'],
            email: $row['email'],
            status: $row['status'],
            role: $row['role'],
            passwordHash: $row['password_hash'],
            firstName: $row['full_name_first_name'],
            lastName: $row['full_name_last_name'],
            middleName: $row['full_name_middle_name'],
            createdAt: $row['created_at'],
            profileId: $row['profile_id']
        );
    }
}
