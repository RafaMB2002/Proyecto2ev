<?php

namespace App\Controller;

use App\Repository\JuegoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route("/api/juego")]
class ApiJuegoController extends AbstractController
{

    private $juegoRepository;

    public function __construct(JuegoRepository $juegoRepository)
    {
        $this->juegoRepository = $juegoRepository;
    }
    #[Route("/getAll", name: "get_all", methods: "GET")]
    public function getAll(): JsonResponse
    {
        $juegos = $this->juegoRepository->findAll();
        $data = [];

        foreach ($juegos as $juego) {
            $data[] = [
                'result' => true,
                'object' => [
                    'id' => $juego->getId(),
                    'nombre' => $juego->getNombre(),
                    'ancho' => $juego->getAncho(),
                    'alto' => $juego->getAlto(),
                    'num_min_players' => $juego->getNumMinPlayers(),
                    'num_max_players' => $juego->getNumMaxPlayers(),
                    'descripcion' => $juego->getDescripcion(),
                    'imagen' => $juego->getImagen()
                ]
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
