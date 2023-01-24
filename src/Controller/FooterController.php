<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
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
