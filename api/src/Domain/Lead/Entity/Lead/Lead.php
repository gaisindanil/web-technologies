<?php

declare(strict_types=1);

namespace App\Domain\Lead\Entity\Lead;

use App\Domain\Common\Types\Id as PublicId;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'leads')]
final class Lead
{
    #[Id]
    #[Column(name: 'id', type: 'integer')]
    #[GeneratedValue]
    private int $id;

    #[Column(type: 'public_id')]
    private PublicId $guid;

    #[Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[Column(type: 'string')]
    private string $locationId;

    #[Column(type: 'text')]
    private string $locationLabel;

    #[Embedded(class: Person::class)]
    private Person $person;

    public function __construct(
        PublicId $guid,
        DateTimeImmutable $createdAt,
        string $locationId,
        string $locationLabel,
        Person $person
    ) {
        $this->guid = $guid;
        $this->createdAt = $createdAt;
        $this->locationId = $locationId;
        $this->locationLabel = $locationLabel;
        $this->person = $person;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getGuid(): PublicId
    {
        return $this->guid;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getLocationLabel(): string
    {
        return $this->locationLabel;
    }

    public function getPerson(): Person
    {
        return $this->person;
    }
}
