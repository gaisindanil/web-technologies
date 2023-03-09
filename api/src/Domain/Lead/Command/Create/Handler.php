<?php

declare(strict_types=1);

namespace App\Domain\Lead\Command\Create;

use App\Domain\Auth\Entity\User\Email;
use App\Domain\Common\Types\Id;
use App\Domain\Flusher;
use App\Domain\Lead\Entity\Lead\Lead;
use App\Domain\Lead\Entity\Lead\LeadRepository;
use App\Domain\Lead\Entity\Lead\Person;
use DateTimeImmutable;
use Exception;

final class Handler
{
    public function __construct(
        readonly Flusher $flusher,
        readonly LeadRepository $leadRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $lead = new Lead(
            new Id($command->id),
            new DateTimeImmutable(),
            $command->location_id,
            $command->location_label,
            new Person(
                new Email($command->person_email),
                $command->person_fullname,
                $command->person_inn,
                $command->person_phone_number,
                $command->passport_series,
                $command->passport_number,
                new DateTimeImmutable($command->passport_date),
                $command->passport_code,
                $command->org_inn,
                $command->org_title,
                $command->snils_number,
                $command->filePassword,
                $command->fileInn,
                $command->fileSnils
            )
        );

        $this->leadRepository->add($lead);

        $this->flusher->flush();
    }
}
