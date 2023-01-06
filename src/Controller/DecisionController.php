<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Entity\Decision;
use App\Form\DecisionType;
use App\Repository\ContributionRepository;
use App\Repository\ContributorRepository;
use App\Repository\DecisionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/decision')]
class DecisionController extends AbstractController
{
    #[Route('/', name: 'app_decision_index', methods: ['GET'])]
    public function index(DecisionRepository $decisionRepository): Response
    {
        return $this->render('decision/index.html.twig', [
            'decisions' => $decisionRepository->findAll(),
        ]);
    }
// @TODO Rediriger vers l'étape 2 (manager les décisions)
// @TODO Rajouter deux méthodes : personnes impliquées, timeline
    #[Route('/new', name: 'app_decision_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DecisionRepository $decisionRepository): Response
    {
        $decision = new Decision();
        $form = $this->createForm(DecisionType::class, $decision);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decisionRepository->save($decision, true);

            return $this->redirectToRoute('app_decision_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('decision/new.html.twig', [
            'decision' => $decision,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_decision_show', methods: ['GET'])]
    public function show(Decision $decision, ContributorRepository $contributorRepo, UserRepository $userRepo): Response
    {
        $decisionId = $decision->getId();
        $contributor = $contributorRepo->findOneContributorBy($this->getUser(), $decisionId);
        $userDecision = $userRepo->findOneByDecisionId($this->getUser(), $decisionId);

        //dd($user);
        return $this->render('decision/show.html.twig', [
            'decision' => $decision,
            'contributor' => $contributor,
            'userDecision' => $userDecision,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_decision_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'app_decision_delete', methods: ['POST'])]
    public function delete(Request $request, Decision $decision, DecisionRepository $decisionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $decision->getId(), $request->request->get('_token'))) {
            $decisionRepository->remove($decision, true);
        }

        return $this->redirectToRoute('app_decision_index', [], Response::HTTP_SEE_OTHER);
    }
}
