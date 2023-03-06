<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ApiUserController extends AbstractController
{
    private $userRepository;
    private $authenticationUtils;

    public function __construct(UserRepository $userRepository, AuthenticationUtils $authenticationUtils)
    {
        $this->userRepository = $userRepository;
        $this->authenticationUtils = $authenticationUtils;
    }

    #[Route('/api/user', name: 'app_api_user')]
    public function index(): Response
    {
        $correo = $this->authenticationUtils->getLastUsername();
        try {

            $user = $this->userRepository->findOneBy(['email' => $correo]);

            $data = [
                'result' => true,
                'object' => [
                    'id' => $user->getId(),
                    'nombreCompleto' => $user->getFullName()
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
