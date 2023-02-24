<?php

namespace App\Controller;

use App\Repository\TramoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tramo', name: 'api_tramo_')]
class TramoController
{

    private $tramoRepository;

    public function __construct(TramoRepository $tramoRepository)
    {
        $this->tramoRepository = $tramoRepository;
    }

    #[Route("/getAll", name: "get_all", methods: "GET")]
    public function getAll(): JsonResponse
    {
        $tramos = $this->tramoRepository->findAll();
        $data = [];

        foreach ($tramos as $tramo) {
            $data[] = [
                'result' => true,
                'object' => [
                    'id' => $tramo->getId(),
                    'inicio' => $tramo->getInicio(),
                    'fin' => $tramo->getFin(),
                ]
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/get/{id}', name: 'get_one', methods: 'GET')]
    public function get($id): JsonResponse
    {
        try {

            $tramo = $this->tramoRepository->findOneBy(['id' => $id]);

            $data = [
                'result' => true,
                'object' => [
                    'id' => $tramo->getId(),
                    'inicio' => $tramo->getInicio(),
                    'fin' => $tramo->getFin(),
                ]
            ];
            $response = new JsonResponse($data, Response::HTTP_OK);
        } catch (\Throwable $th) {

            $data = [
                'result' => false
            ];

            $response = new JsonResponse($data, Response::HTTP_NOT_FOUND);
        }


        return $response;
    }
}
