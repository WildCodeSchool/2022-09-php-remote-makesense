<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AvatarFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/account', name: '_account')]
    public function show(): Response
    {
            return $this->render('user/account.html.twig');
    }

    #[Route('/avatar', name: '_new_avatar', methods: ['GET', 'POST'])]
    public function newAvatar(
        Request $request,
        UserRepository $userRepository,
        ): response {
        /** @var ?User $user */
        $user = $this->getUser();
        $form = $this->createForm(AvatarFormType::class, $user, [
            'action' => $this->generateUrl('app_user_new_avatar')]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $userRepository->save($user, true);
        }

        return $this->renderForm('user/_modal_avatar.html.twig', [
            'form' => $form,
            //'user' => $user
        ]);
    }
}
