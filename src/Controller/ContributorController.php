<?php

namespace App\Controller;

use App\Entity\Contributor;
use App\Form\MyDecisionSearchType;
use App\Form\MyPassedContributionsType;
use App\Form\MyPendingContributionsType;
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
    public function decisionContributor(
        Request $request,
        ContributorRepository $contributorRepo,
        Paginatorinterface $paginator
    ): Response {
        $pendingForm = $this->createform(MyPendingContributionsType::class);
        $pendingForm ->handleRequest($request);

        $addedForm = $this->createform(MyPassedContributionsType::class);
        $addedForm->handleRequest($request);

        if ($pendingForm ->isSubmitted() && $pendingForm ->isValid()) {
            $search = $pendingForm ->getData()['search'];
            $contributors = $paginator->paginate(
                $contributorRepo->findPendingContributions($this->getUser(), $search),
                $request->query->getInt('page', 1),
                9
            );
        } elseif ($addedForm->isSubmitted() && $addedForm->isValid()) {
            $search = $addedForm->getData()['search'];
            $contributors = $paginator->paginate(
                $contributorRepo->findAddedContributions($this->getUser(), $search),
                $request->query->getInt('page', 1),
                9
            );
        } else {
            $data = $contributorRepo->findAllContributorsBy($this->getUser());
            $contributors = $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                11
            );
        }
        return $this->render('contributor/contributor_decisions.html.twig', [
            'contributors' => $contributors,
            'pendingForm' => $pendingForm ->createView(),
            'addedForm' => $addedForm->createView(),
        ]);
    }
}
