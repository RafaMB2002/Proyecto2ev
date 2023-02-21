<?php

namespace App\Controller;

use App\Entity\Juego;
use App\Form\Juego1Type;
use App\Repository\JuegoRepository;
use src\Event\JuegoCreateEvent;
use src\EventSubscriber\JuegoSubscriber;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/juego/crud')]
class JuegoCrudController extends AbstractController
{
    #[Route('/', name: 'app_juego_crud_index', methods: ['GET'])]
    public function index(JuegoRepository $juegoRepository): Response
    {
        return $this->render('juego_crud/index.html.twig', [
            'juegos' => $juegoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_juego_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JuegoRepository $juegoRepository): Response
    {
        $juego = new Juego();
        $form = $this->createForm(Juego1Type::class, $juego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $juegoRepository->save($juego, true);

            return $this->redirectToRoute('app_juego_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('juego_crud/new.html.twig', [
            'juego' => $juego,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_juego_crud_show', methods: ['GET'])]
    public function show(Juego $juego): Response
    {
        return $this->render('juego_crud/show.html.twig', [
            'juego' => $juego,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_juego_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Juego $juego, JuegoRepository $juegoRepository): Response
    {
        $form = $this->createForm(Juego1Type::class, $juego);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $juegoRepository->save($juego, true);

            return $this->redirectToRoute('app_juego_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('juego_crud/edit.html.twig', [
            'juego' => $juego,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_juego_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Juego $juego, JuegoRepository $juegoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $juego->getId(), $request->request->get('_token'))) {
            $juegoRepository->remove($juego, true);
        }

        return $this->redirectToRoute('app_juego_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
