<?php

namespace App\Controller;

use App\Entity\Mesa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\MesaRepository;
use App\Form\FormNewMesaType;

class MetodosMesaController extends AbstractController
{
    private $mesaRepository;

    public function __construct(MesaRepository $mesaRepository)
    {
        $this->mesaRepository = $mesaRepository;
    }

    #[Route('/metodos/newMesa', name: 'app_metodos_new_mesa')]
    public function metodoNewMesa(Request $request): Response
    {
        $mesa = new Mesa();

        $form = $this->createForm(FormNewMesaType::class, $mesa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mesa = $form->getData();
            $this->mesaRepository->saveMesa($mesa->getAnchura(), $mesa->getAltura());
            return $this->redirectToRoute('gestion_mesas');
        }
        return $this->render('gestionMesas/form.html.twig', [
            'form' => $form,
        ]);
    }

}
