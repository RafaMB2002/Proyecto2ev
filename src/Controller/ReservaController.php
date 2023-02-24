<?php

namespace App\Controller;

use App\Repository\JuegoRepository;
use App\Repository\MesaRepository;
use App\Repository\ReservaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

#[Route('/api/reserva', name: 'api_reserva_')]
class ReservaController
{
    private $reservaRepository;
    private $mesaRepository;
    private $userRepository;
    private $juegoRepository;

    public function __construct(ReservaRepository $reservaRepository, MesaRepository $mesaRepository, UserRepository $userRepository, JuegoRepository $juegoRepository)
    {
        $this->reservaRepository = $reservaRepository;
        $this->mesaRepository = $mesaRepository;
        $this->userRepository = $userRepository;
        $this->juegoRepository = $juegoRepository;
    }

    //#[Security(is_garanted: 'ROLE_ADMIN')]
    #[Route('/add', name: 'add', methods: 'POST',)]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $fechaInicio = $data['fecha_inicio'];
        $fechaFin = $data['fecha_fin'];
        $fechaCancelacion = $data['fecha_cancelacion'];
        $presentado = $data['presentado'];
        $mesaId = $data['mesa_id'];
        $userId = $data['user_id'];
        $juegoId = $data['juego_id'];

        if (empty($fechaInicio) || empty($fechaFin) || empty($fechaCancelacion) || empty($presentado) || empty($mesaId) || empty($userId) || empty($juegoId)) {
            throw new NotFoundHttpException('Esperando parametros obligatorios!');
        }

        $reserva = $this->reservaRepository->saveReserva($fechaInicio, $fechaFin, $fechaCancelacion, $presentado, $mesaId, $userId, $juegoId);

        $data = [
            'status' => true,
            'object' => [$reserva->toArray()]
        ];

        return new JsonResponse($data, Response::HTTP_CREATED);
    }

    //#[Security(is_garanted: 'ROLE_ADMIN')]
    #[Route('/get/{id}', name: 'get_one', methods: 'GET')]
    public function get($id): JsonResponse
    {
        try {

            $reserva = $this->reservaRepository->findOneBy(['id' => $id]);

            $data = [
                'result' => true,
                'object' => [
                    'id' => $reserva->getId(),
                    'fecha_inicio' => $reserva->getFechaInicio(),
                    'fecha_fin' => $reserva->getFechaFin(),
                    'fecha_cancelacion' => $reserva->getFechaCancelacion(),
                    'presentado' => $reserva->isPresentado(),
                    'mesa_id' => $reserva->getMesa()->getId(),
                    'user_id' => $reserva->getUser()->getId(),
                    'juego_id' => $reserva->getJuego()->getId(),
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
        $reservas = $this->reservaRepository->findAll();
        $data = [];

        foreach ($reservas as $reserva) {
            $data[] = [
                'result' => true,
                'object' => [
                    'id' => $reserva->getId(),
                    'fecha_inicio' => $reserva->getFechaInicio(),
                    'fecha_fin' => $reserva->getFechaFin(),
                    'fecha_cancelacion' => $reserva->getFechaCancelacion(),
                    'presentado' => $reserva->isPresentado(),
                    'mesa_id' => $reserva->getMesa()->getId(),
                    'user_id' => $reserva->getUser()->getId(),
                    'juego_id' => $reserva->getJuego()->getId(),
                ]
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    // #[Security(is_garanted: 'ROLE_ADMIN')]
    #[Route("/update/{id}", name: "update", methods: "PUT")]
    public function update($id, Request $request): JsonResponse
    {
        $reserva = $this->reservaRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['fecha_inicio']) ? true : $reserva->setFechaInicio($data['fecha_inicio']);
        empty($data['fecha_fin']) ? true : $reserva->setFechaFin($data['fecha_fin']);
        empty($data['fecha_cancelacion']) ? true : $reserva->setFechaCancelacion($data['fecha_cancelacion']);
        empty($data['presentado']) ? true : $reserva->setPresentado($data['presentado']);
        empty($data['mesa_id']) ? true : $reserva->setMesa($this->mesaRepository->findOneBy(['id' => $data['mesa_id']]));
        empty($data['user_id']) ? true : $reserva->setUser($this->userRepository->findOneBy(['id' => $data['user_id']]));
        empty($data['juego_id']) ? true : $reserva->setJuego($this->juegoRepository->findOneBy(['id' => $data['juego_id']]));

        $updatedReserva = $this->reservaRepository->updateReserva($reserva);

        $data = [
            "result" => true,
            "object" => $updatedReserva->toArray()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    //#[Security(is_garanted: 'ROLE_ADMIN')]
    #[Route("/delete/{id}", name: "delete", methods: "DELETE")]
    public function delete($id): JsonResponse
    {
        $reserva = $this->reservaRepository->findOneBy(['id' => $id]);

        $this->reservaRepository->removeReserva($reserva);
        $data = ["result" => true];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
