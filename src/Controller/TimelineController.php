<?php

namespace App\Controller;

use App\Entity\Timeline;
use App\Form\TimelineType;
use App\Repository\TimelineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/timeline')]
class TimelineController extends AbstractController
{
    #[Route('/', name: 'app_timeline_index', methods: ['GET'])]
    public function index(TimelineRepository $timelineRepository): Response
    {
        return $this->render('timeline/index.html.twig', [
            'timelines' => $timelineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_timeline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TimelineRepository $timelineRepository): Response
    {
        $timeline = new Timeline();
        $form = $this->createForm(TimelineType::class, $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $timelineRepository->save($timeline, true);

            return $this->redirectToRoute('app_timeline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('timeline/new.html.twig', [
            'timeline' => $timeline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_timeline_show', methods: ['GET'])]
    public function show(Timeline $timeline): Response
    {
        return $this->render('timeline/show.html.twig', [
            'timeline' => $timeline,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_timeline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Timeline $timeline, TimelineRepository $timelineRepository): Response
    {
        $form = $this->createForm(TimelineType::class, $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $timelineRepository->save($timeline, true);

            return $this->redirectToRoute('app_timeline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('timeline/edit.html.twig', [
            'timeline' => $timeline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_timeline_delete', methods: ['POST'])]
    public function delete(Request $request, Timeline $timeline, TimelineRepository $timelineRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $timeline->getId(), $request->request->get('_token'))) {
            $timelineRepository->remove($timeline, true);
        }

        return $this->redirectToRoute('app_timeline_index', [], Response::HTTP_SEE_OTHER);
    }
}
