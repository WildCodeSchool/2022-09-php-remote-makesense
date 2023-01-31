<?php

namespace App\Controller\Admin;

use App\Entity\Decision;
use App\Repository\ContributorRepository;
use App\Repository\DecisionRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Route('/decisions')]
class AdminDecisionController extends AbstractController
{
    #[Route('/', name: 'app_admin_decisions')]
    public function index(
        DecisionRepository $decisionRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $decisions = $paginator->paginate(
            $decisionRepository->findAllByDate(),
            $request->query->getInt('page', 1),
            7
        );
        return $this->render('admin/admin_decision/index.html.twig', [
            'decisions' => $decisions,
        ]);
    }

    #[Route('/decision/{id}', name: 'app_admin_decision_show', methods: ['GET'])]
    public function show(Decision $decision, ContributorRepository $contributorRepo, UserRepository $userRepo): Response
    {
        $decisionId = $decision->getId();
        $contributor = $contributorRepo->findOneContributorBy($this->getUser(), $decisionId);
        $userDecision = $userRepo->findOneByDecisionId($this->getUser(), $decisionId);

        return $this->render('/admin/admin_decision/show.html.twig', [
            'decision' => $decision,
            'contributor' => $contributor,
            'userDecision' => $userDecision,
        ]);
    }
}
