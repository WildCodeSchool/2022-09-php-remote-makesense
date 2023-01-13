<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Repository\ContributorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contributor', name: 'app_')]
class ContributorController extends AbstractController
{
    #[Route('/', name: 'contributor')]
    public function index(): Response
    {
        return $this->render('contributor/index.html.twig', [
            'controller_name' => 'ContributorController',
        ]);
    }

    #[Route('/decisions', name: 'contributor_decisions', methods: ['GET'])]
    public function decisionsContributor(ContributorRepository $contributorRepo): Response
    {
        return $this->render('contributor/contributor_decisions.html.twig', [
            'contributors' => $contributorRepo->findAllContributorsBy($this->getUser()),
        ]);
    }
}
