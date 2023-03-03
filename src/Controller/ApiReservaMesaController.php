<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/reserva/mesa', name: 'app_api_reserva_mesa')]
class ApiReservaMesaController extends AbstractController
{

    #[Route('/mesaReservaFecha', name: 'app_api_reserva_por_fecha')]
    public function mesasConReservaPorFecha($fecha): JsonResponse
    {
        $reservas = $this->reservaRepository->createQueryBuilder('i');
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
                    'tramo_id' => $reserva->getTramo()->getId()
                ]
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
