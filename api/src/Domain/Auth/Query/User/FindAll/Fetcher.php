<?php

declare(strict_types=1);

namespace App\Domain\Auth\Query\User\FindAll;

use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

final class Fetcher
{
    private Connection $connection;

    private PaginatorInterface $paginator;

    public function __construct(Connection $connection, PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    public function fetch(Filter $filter, int $page, int $limit): PaginationInterface
    {
        $qb = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'public_id',
                'profile_id',
                'status',
                'email',
                'role',
                'password_hash',
                'created_at',
                'reset_token',
                'new_email_reset_token',
                'new_email',
                'confirm_token',
                'full_name_first_name AS first_name',
                'full_name_last_name AS last_name',
                'full_name_middle_name AS middle_name',
                'title AS organization_title',
            ])
            ->from('users');

        if ($filter->status) {
            $qb->where('status = :status');
            $qb->setParameter('status', $filter->status->getName());
        }

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
