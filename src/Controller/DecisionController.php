<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Entity\Decision;
use App\Entity\Timeline;
use App\Form\DecisionType;
use App\Form\DecisionStep2Type;
use App\Form\DecisionStep3Type;
use App\Repository\DecisionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/decision', name: 'app_decision_')]
class DecisionController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(DecisionRepository $decisionRepository): Response
    {
        return $this->render('decision/index.html.twig', [
            'decisions' => $decisionRepository->findAll(),
        ]);
    }

    #[Route('/{id}/step2', name: 'step2', methods: ['GET'])]
    public function step2(Decision $decision, Request $request, DecisionRepository $decisionRepository)
    {
        $form = $this->createForm(DecisionStep2Type::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);
            return $this->redirectToRoute('app_decision_step3', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('decision/edit-step2.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/step3', name: 'step3', methods: ['GET'])]
    public function step3(Decision $decision, Request $request, DecisionRepository $decisionRepository)
    {
        $timeline = new Timeline();

        $form = $this->createForm(DecisionStep3Type::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);
        }
        return $this->renderForm('decision/edit-step3.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, DecisionRepository $decisionRepository): Response
    {
        $decision = new Decision();

        $form = $this->createForm(DecisionType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);

            return $this->redirectToRoute('app_decision_step2', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('decision/new.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Decision $decision): Response
    {
        return $this->render('decision/show.html.twig', [
            'decision' => $decision,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Decision $decision, DecisionRepository $decisionRepository): Response
    {
        $form = $this->createForm(DecisionType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);

            return $this->redirectToRoute('app_decision_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('decision/edit.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Decision $decision, DecisionRepository $decisionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $decision->getId(), $request->request->get('_token'))) {
            $decisionRepository->remove($decision, true);
        }

        return $this->redirectToRoute('app_decision_index', [], Response::HTTP_SEE_OTHER);
    }
}
