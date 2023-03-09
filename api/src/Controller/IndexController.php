<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Auth\Entity\User\UserRepository;
use App\Domain\Auth\Service\PasswordHashGenerator;
use App\Domain\Common\Types\Id;
use App\Domain\Flusher;
use App\Domain\Lead\Entity\Lead\LeadRepository;
use App\Domain\Lead\Query\FindAll;
use App\Domain\Lead\Query\FindOne;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IndexController extends AbstractController
{
    private const PER_PAGE = 25;

    public function __construct(
        readonly FindAll\Fetcher $findAllFetcher,
        readonly FindOne\Fetcher $findOneFetcher
    ) {
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->redirectToRoute('dashboard');
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(Request $request): Response
    {
        $leads = $this->findAllFetcher->fetch(new FindAll\Filter(), $request->query->getInt('page', 1), self::PER_PAGE);

        return $this->render('app/index.html.twig', [
            'leads' => $leads,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route('/lead/show/{guid}', name: 'lead_show')]
    public function show(string $guid): Response
    {
        $lead = $this->findOneFetcher->fetch(new FindOne\Query($guid));

        return $this->render('app/show.html.twig', [
            'lead' => $lead,
        ]);
    }

    #[Route('/lead/{guid}/delete', name: 'lead_delete', methods: ["POST"])]
    public function delete(string $guid, LeadRepository $leadRepository, Flusher $flusher): Response
    {
        $lead = $leadRepository->getByGuid(new Id($guid));

        $leadRepository->remove($lead);

        $flusher->flush();

        return $this->redirectToRoute('dashboard');
    }

}
