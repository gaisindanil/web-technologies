<?php

declare(strict_types=1);

namespace App\Domain\Lead\Entity\Lead;

use App\Domain\Common\Types\Id;
use App\Domain\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class LeadRepository
{
    private EntityManagerInterface $entityManager;

    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Lead::class);
    }

    public function add(Lead $lead): void
    {
        $this->entityManager->persist($lead);
    }

    public function get(int $id): Lead
    {
        $lead = $this->repository->find($id);
        if (!$lead instanceof Lead) {
            throw new EntityNotFoundException('Lead is not found.');
        }
        return $lead;
    }

    public function getByGuid(Id $guid): Lead
    {
        $lead = $this->repository->findOneBy(['guid' => $guid]);
        if (!$lead instanceof Lead) {
            throw new EntityNotFoundException('Lead is not found.');
        }
        return $lead;
    }

    public function remove(Lead $lead): void
    {
        $this->entityManager->remove($lead);
    }
}
