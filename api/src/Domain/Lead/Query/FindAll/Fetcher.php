<?php

declare(strict_types=1);

namespace App\Domain\Lead\Query\FindAll;

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
                'guid',
                'created_at',
                'location_id',
                'location_label',
                'person_org_inn',
                'person_ogr_title',
                'person_email',
                'person_full_name',
                'person_inn',
                'person_phone_number',
                'person_series',
                'person_number',
                'person_date',
                'person_code',
                'person_snils_number',
            ])
            ->from('leads');

        return $this->paginator->paginate($qb, $page, $limit);
    }
}
