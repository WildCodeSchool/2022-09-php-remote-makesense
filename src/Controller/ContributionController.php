<?php

namespace App\Controller;

use App\Entity\Contribution;
use App\Entity\Contributor;
use App\Entity\Decision;
use App\Entity\User;
use App\Form\ContributionType;
use App\Repository\ContributionRepository;
use App\Repository\ContributorRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;

#[Route('/contribution', name: 'app_contribution')]
class ContributionController extends AbstractController
{
    #[Route('/', name: '_i')]
    public function index(): Response
    {
        return $this->render('contribution/index.html.twig', [
            'controller_name' => 'ContributionController',
        ]);
    }

    /**
     * @throws \Exception
     */

    #[Route('/new/opinion/{decision}', name: '_new_opinion', methods: ['GET', 'POST'])]
    public function newOpinion(
        Request $request,
        ContributorRepository $contributorRepos,
        ContributionRepository $contributionRepos,
        Decision $decision,
        FormFactoryInterface $formFactory
    ): Response {
        $contribution = new Contribution();
        $form = $formFactory->createNamed('form_opinion', ContributionType::class, $contribution, [
            'action' => $this->generateUrl('app_contribution_new_opinion', ['decision' => $decision->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contribution->setDecision($decision);
            /** @var ?User $user */
            $user = $this->getUser();
            $contributor = $contributorRepos->findOneBy(['employee' => $user->getEmployee(), 'decision' => $decision]);
            if ($contributor) {
                $contribution->setContributor($contributor);
                $contribution->setType('avis');
                $contributionRepos->save($contribution, true);
                $this->addFlash('success', "L'avis a bien été posté !");
            } else {
                $this->addFlash('danger', "L'avis n'a pas pu être posté !");
            }
            return $this->redirectToRoute('app_decision_show', ['id' => $decision->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contribution/_modal_new_avis.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/new/conflict/{decision}', name: '_new_conflict', methods: ['GET', 'POST'])]
    public function newConflict(
        Request $request,
        ContributorRepository $contributorRepos,
        ContributionRepository $contributionRepos,
        Decision $decision
    ): Response {
        $contribution = new Contribution();
        $form = $this->createForm(ContributionType::class, $contribution, [
            'action' => $this->generateUrl('app_contribution_new_conflict', ['decision' => $decision->getId()])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contribution->setDecision($decision);
            /** @var ?User $user */
            $user = $this->getUser();
            $contributor = $contributorRepos->findOneBy(['employee' => $user->getEmployee(), 'decision' => $decision]);
            if ($contributor) {
                $contribution->setContributor($contributor);
                $contribution->setType('conflit');
                $contributionRepos->save($contribution, true);
                $this->addFlash('success', "Le conflit a bien été posté !");
            } else {
                $this->addFlash('danger', "Le conflit n'a pas pu être posté !");
            }

            return $this->redirectToRoute('app_decision_show', ['id' => $decision->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contribution/_modal_new_conflit.html.twig', [
            'form' => $form,
        ]);
    }
}
