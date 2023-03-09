<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Domain\Common\Types\Id;
use App\Domain\Lead\Command\Create\Command;
use App\Domain\Lead\Command\Create\Handler;
use App\Domain\Lead\Query\FindOne\Fetcher;
use App\Domain\Lead\Query\FindOne\Query;
use App\Service\UploadedBase64File;
use App\Service\Uploader\FileUploader;
use DomainException;
use League\Flysystem\FilesystemException;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class IndexController extends AbstractController
{
    public function __construct(
        readonly Fetcher $fetcher
    ) {
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param Handler $handler
     * @param FileUploader $fileUploader
     * @return JsonResponse
     * @throws FilesystemException
     * @OA\Response( response="200", description="Отправка заявки")
     * @OA\RequestBody(
     * @OA\JsonContent(type="object",
     * @OA\Property(property="snils_number", type="string", description="Номер  снила"),
     * @OA\Property(property="location_id", type="string", description="Адрес"),
     * @OA\Property(property="location_label", type="string", description="Адрес"),
     * @OA\Property(property="org_inn", type="string", description="Инн"),
     * @OA\Property(property="org_title", type="string", description="Название организации"),
     * @OA\Property(property="person_email", type="string", description="Email"),
     * @OA\Property(property="person_fullname", type="string", description="Фио"),
     * @OA\Property(property="person_inn", type="string", description="Инн"),
     * @OA\Property(property="person_phone_number", type="string", description="Номер телефона"),
     * @OA\Property(property="passport_series", type="string", description="Серия паспорта"),
     * @OA\Property(property="passport_number", type="string", description="Номер паспорта"),
     * @OA\Property(property="passport_date", type="string", description="Дата паспорта"),
     * @OA\Property(property="passport_code", type="string", description="Код паспорта"),
     * @OA\Property(property="file_passport", type="string", description="Файл паспорта"),
     * @OA\Property(property="file_snils", type="string", description="Файл снилс"),
     * @OA\Property(property="file_inn", type="string", description="Файл инн"),
     * )),
     * @OA\Tag(name="lead")
     *
     */
    #[Route('/api/v1/lead/add', name: 'lead_add', methods: ['POST'])]
    public function createLead(Request $request, ValidatorInterface $validator, Handler $handler, FileUploader $fileUploader): JsonResponse
    {
        $parsed = json_decode($request->getContent(), true);

        if (!$parsed) {
            throw new BadRequestException('Invalid data.');
        }

        $errors = $validator->validate($parsed, new Collection([
            'snils_number' => [new NotNull(), new Type(['string'])],
            'location_id' => [new NotNull(), new Type(['string'])],
            'location_label' => [new NotNull(), new Type(['string'])],
            'org_inn' => [new NotNull(), new Type(['string'])],
            'org_title' => [new NotNull(), new Type(['string'])],
            'person_email' => [new NotNull(), new Type(['string'])],
            'person_fullname' => [new NotNull(), new Type(['string'])],
            'person_inn' => [new NotNull(), new Type(['string'])],
            'person_phone_number' => [new NotNull(), new Type(['string'])],
            'passport_series' => [new NotNull(), new Type(['string'])],
            'passport_number' => [new NotNull(), new Type(['string'])],
            'passport_date' => [new NotNull(), new Type(['string'])],
            'passport_code' => [new NotNull(), new Type(['string'])],
            'file_passport' => [new NotNull(), new Type(['string'])],
            'file_snils' => [new NotNull(), new Type(['string'])],
            'file_inn' => [new Type(['string'])],
        ]));



        if ($errors->count() > 0) {
            $errorList = [];

            foreach ($errors as $violation) {
                /** @var ConstraintViolation $violation */
                $errorList[$violation->getPropertyPath()] = $violation->getMessage();
            }

            return new JsonResponse($errorList);
        }

        $passportFile = new UploadedBase64File($parsed['file_passport'], 'test');
        $snilsFile = new UploadedBase64File($parsed['file_passport'], 'test');
        $passwordF = $fileUploader->upload($passportFile);
        $snilsF = $fileUploader->upload($snilsFile);

        if (isset($parsed['file_inn'])) {
            $innFile = new UploadedBase64File($parsed['file_inn'], 'test');
            $innF = $fileUploader->upload($innFile);
        }

        $command = new Command(
            $guid = Id::next()->getValue(),
            $parsed['snils_number'],
            $parsed['location_id'],
            $parsed['location_label'],
            $parsed['org_inn'],
            $parsed['org_title'],
            $parsed['person_email'],
            $parsed['person_fullname'],
            $parsed['person_inn'],
            $parsed['person_phone_number'],
            $parsed['passport_series'],
            $parsed['passport_number'],
            $parsed['passport_date'],
            $parsed['passport_code'],
            $passwordF->getPath() . '/' . $passwordF->getName(),
            $snilsF->getPath() . '/' . $snilsF->getName(),
            isset($parsed['file_inn']) ? $innF->getPath() . '/' . $innF->getName() : null,
        );

        try {
            $handler->handle($command);
        } catch (DomainException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        $lead = $this->fetcher->fetch(new Query($guid));
        return new JsonResponse([
            'status' => 'ok',
            'data' => $lead,
        ]);
    }
}
