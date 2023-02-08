<?php

namespace App\Controller;

use App\Repository\MesaRepository;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/mesa', name: 'api_mesa_')]
class MesaController
{
    private $mesaRepository;

    public function __construct(MesaRepository $mesaRepository)
    {
        $this->mesaRepository = $mesaRepository;
    }

    #[Route('/add', name: 'add', methods: 'POST')]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $anchura = $data['anchura'];
        $altura = $data['altura'];

        if (empty($anchura) || empty($altura)) {
            throw new NotFoundHttpException('Esperando parametros obligatorios!');
        }

        $mesa = $this->mesaRepository->saveMesa($anchura, $altura);

        $data = [
            'status' => true,
            'object' => [$mesa->toArray()]
        ];

        return new JsonResponse($data, Response::HTTP_CREATED);
    }
    #[Route('/get/{id}', name: 'get_one', methods: 'GET')]
    public function get($id): JsonResponse
    {
        try {

            $mesa = $this->mesaRepository->findOneBy(['id' => $id]);

            $data = [
                'result' => true,
                'object' => [
                    'id' => $mesa->getId(),
                    'anchura' => $mesa->getAnchura(),
                    'altura' => $mesa->getAltura(),
                    'x' => $mesa->getX(),
                    'y' => $mesa->getY(),
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

    #[Route("/getAll", name: "get_all", methods: "GET")]
    public function getAll(): JsonResponse
    {
        $mesas = $this->mesaRepository->findAll();
        $data = [];

        foreach ($mesas as $mesa) {
            $data[] = [
                'result' => true,
                'object' => [
                    'id' => $mesa->getId(),
                    'anchura' => $mesa->getAnchura(),
                    'altura' => $mesa->getAltura(),
                    'x' => $mesa->getX(),
                    'y' => $mesa->getY(),
                ]
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route("/update/{id}", name: "update", methods: "PUT")]
    public function update($id, Request $request): JsonResponse
    {
        $mesa = $this->mesaRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['anchura']) ? true : $mesa->setAnchura($data['anchura']);
        empty($data['altura']) ? true : $mesa->setAltura($data['altura']);
        empty($data['x']) ? true : $mesa->setX($data['x']);
        empty($data['y']) ? true : $mesa->setY($data['y']);

        $updatedMesa = $this->mesaRepository->updateMesa($mesa);

        $data = [
            "result" => true,
            "object" => $updatedMesa->toArray()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route("/delete/{id}", name: "delete", methods: "DELETE")]
    public function delete($id): JsonResponse
    {
        $mesa = $this->mesaRepository->findOneBy(['id' => $id]);

        $this->mesaRepository->removeMesa($mesa);
        $data = ["result" => true];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
