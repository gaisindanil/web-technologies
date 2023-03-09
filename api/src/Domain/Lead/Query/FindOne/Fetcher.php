<?php

declare(strict_types=1);

namespace App\Domain\Lead\Query\FindOne;

use Doctrine\DBAL\Connection;
use Exception;

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
    public function fetch(Query $query): ?Lead
    {
        $result = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'guid',
                'created_at',
                'location_id',
                'location_label',
                'person_email',
                'person_full_name',
                'person_inn',
                'person_phone_number',
                'person_series',
                'person_number',
                'person_date',
                'person_code',
                'person_org_inn',
                'person_ogr_title as person_org_title',
                'person_snils_number',
                'person_password_file',
                'person_inn_file',
                'person_snils_file',
            ])
            ->from('leads')
            ->where('guid = :guid')
            ->setParameter('guid', $query->guid)
            ->executeQuery();

//        /**
//         * @var array{
//         *      id: int,
//         *      public_id: string,
//         *      title: string,
//         *      address: string,
//         *      status: string,
//         *      created_at: string,
//         * } | false $row
//         */
        $row = $result->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new Lead(
            id: $row['id'],
            guid: $row['guid'],
            createdAt: $row['created_at'],
            locationId: $row['location_id'],
            locationLabel: $row['location_label'],
            personEmail: $row['person_email'],
            personFullName: $row['person_full_name'],
            personInn: $row['person_inn'],
            personPhoneNumber: $row['person_phone_number'],
            personSeries: $row['person_series'],
            personNumber: $row['person_number'],
            personDate: $row['person_date'],
            personCode: $row['person_code'],
            personOrgInn: $row['person_org_inn'],
            personOrgTitle: $row['person_org_title'],
            personSnilsNumber: $row['person_snils_number'],
            personPassportFile: $row['person_password_file'],
            personSnilsFile: $row['person_snils_file'],
            personInnFile: $row['person_inn_file']
        );
    }
}
