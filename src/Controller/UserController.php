<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function show(UserRepository $userRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('user/account.html.twig', [
            'user' => $userRepository->findOneBy(['id' => $user->getId()]),
        ]);
    }
}
