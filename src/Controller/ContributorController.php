<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Repository\ContributorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function decisionsContributor(Request $request, ContributorRepository $contributorRepo, Paginatorinterface $paginator): Response
    {
        $contributors = $contributorRepo->findAllContributorsBy($this->getUser());
        $contributors = $paginator->paginate(
            $contributors,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('contributor/contributor_decisions.html.twig', [
            'contributors' => $contributors,
        ]);
    }
}
