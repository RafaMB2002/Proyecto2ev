<?php

namespace App\Service;

use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PdfGenerator{
    private $userRepository;
    private $authenticationUtils;

    public function __construct(UserRepository $userRepository, AuthenticationUtils $authenticationUtils)
    {
        $this->userRepository = $userRepository;
        $this->authenticationUtils = $authenticationUtils;
    }

    public function createPdf(){
        $usuario = $this->userRepository->findOneBy(['email' => $this->authenticationUtils->getLastUsername()]);
        $data = [
            'imageSrc'  => $this->imageToBase64($this->getParameter('kernel.project_dir') . '/public/img/avatar/user.png'),
            'name'         => $usuario->getFullName(),
            'address'      => '',
            'mobileNumber' => '',
            'email'        => $usuario->getEmail()
        ];
        $html =  $this->renderView('pdf_generator/index.html.twig', $data);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream(time().'nuevoPdf.pdf');
    }

    private function imageToBase64($path) {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
}