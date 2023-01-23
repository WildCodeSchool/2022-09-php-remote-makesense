<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use App\Repository\TimelineRepository;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        DecisionRepository $decisionRepository,
        TimeLineRepository $timelineRepository,
    ): Response {
        $decisions = $decisionRepository->findAllByTimeline();
        $userDecisions = $decisionRepository->findFirstThreeByUser($this->getUser());
        $userContributions = $timelineRepository->findAllByContributor($this->getUser());

        return $this->render('home/index.html.twig', [
            'decision' => $decisions,
            'userDecisions' => $userDecisions,
            'userContributions' => $userContributions,
        ]);
    }
}
