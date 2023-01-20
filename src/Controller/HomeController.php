<?php

namespace App\Controller;

use App\Repository\DecisionRepository;
use App\Repository\TimelineRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Decision;
use App\Entity\Timeline;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DecisionRepository $decisionRepository, TimeLineRepository $timelineRepository): Response
    {
        $decisions = $decisionRepository->findAllByTimeline();
        $userDecisions = $decisionRepository->findFirstThreeByUser($this->getUser());
        $userContributions = $timelineRepository->findAllByContributor($this->getUser());

        return $this->render('home/index.html.twig', [
            'decision' => $decisions,
            'userDecisions' => $userDecisions,
            'userContributions' => $userContributions,
        ]);
    }

    #[Route('/aboutus', name: 'app_about_us')]
    public function aboutUs(): Response
    {
        return $this->render('home/about_us.html.twig');
    }

    #[Route('/legalmentions', name: 'app_legal_mentions')]
    public function legalMentions(): Response
    {
        return $this->render('home/legal_mentions.html.twig');
    }
}
