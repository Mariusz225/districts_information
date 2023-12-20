<?php

namespace App\Service\Json;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class JsonSerializationService
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public function getSerializedJson($object, string $serializeGroup): JsonResponse
    {
        $data = $this->serializer->serialize($object, JsonEncoder::FORMAT, ['groups' => $serializeGroup]);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }
}
