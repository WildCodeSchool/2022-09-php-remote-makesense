<?php

namespace App\Controller;

use App\Entity\Decision;
use App\Entity\User;
use App\Form\decision\DecisionType;
use App\Form\decision\DefinitiveDecisionType;
use App\Form\decision\FirstDecisionType;
use App\Repository\ContributorRepository;
use App\Repository\DecisionRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
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

    #[Route('/mine', name: 'app_decision_mine', methods: ['GET'])]
    public function myDecisions(Request $request, DecisionRepository $decisionRepository, PaginatorInterface $paginator): Response
    {
        $decisions = $decisionRepository->findAllByUser($this->getUser());
        $decisions = $paginator->paginate(
            $decisions,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('decision/my_decisions.html.twig', [
            'decisions' => $decisions,
        ]);
    }

// @TODO Rediriger vers l'étape 2 (manager les décisions)
// @TODO Rajouter deux méthodes : personnes impliquées, timeline
    #[Route('/new', name: 'app_decision_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DecisionRepository $decisionRepository): Response
    {
        $decision = new Decision();
        $form = $this->createForm(DecisionType::class, $decision);
        // @TODO lier le User avec la New Decision
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

    #[Route('/new/firstDecision/{decision}', name: '_new_first_decision', methods: ['GET', 'POST'])]
    public function addFirstDecision(
        Request $request,
        Decision $decision,
        DecisionRepository $decisionRepository
    ): Response {
        $form = $this->createForm(FirstDecisionType::class, $decision, [
        'action' => $this->generateUrl('_new_first_decision', ['decision' => $decision->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $owner = $decisionRepository->findOneBy(['user' => $this->getUser()]);
            if ($owner) {
                 $decisionRepository->save($decision, true);
                 $this->addFlash('success', "Votre première décision a bien été postée !");
            } else {
                 $this->addFlash('danger', "Votre première décision n'a pas pu être postée !");
            }
             return $this->redirectToRoute('app_decision_show', ['id' => $decision->getId()], Response::HTTP_SEE_OTHER);
        }

         return $this->renderForm('decision/_modal_new_first_decision.html.twig', [
             'form' => $form,
         ]);
    }

    #[Route('/new/DefinitiveDecision/{decision}', name: '_new_definitive_decision', methods: ['GET', 'POST'])]
    public function addDefinitiveDecision(
        Request $request,
        Decision $decision,
        DecisionRepository $decisionRepository
    ): Response {
        $form = $this->createForm(DefinitiveDecisionType::class, $decision, [
            'action' => $this->generateUrl('_new_definitive_decision', ['decision' => $decision->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $owner = $decisionRepository->findOneBy(['user' => $this->getUser()]);
            if ($owner) {
                $decisionRepository->save($decision, true);
                $this->addFlash('success', "Votre décision définitive a bien été postée !");
            } else {
                $this->addFlash('danger', "Votre décision définitive n'a pas pu être postée !");
            }
            return $this->redirectToRoute('app_decision_show', ['id' => $decision->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('decision/_modal_new_definitive_decision.html.twig', [
            'form' => $form,
        ]);
    }
}
