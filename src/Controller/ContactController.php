<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */

    #[Route('/contactus', name: 'contact_us')]
    public function contactUs(Request $request, MailerService $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $subject = 'Message de ' . $contactFormData['firstName'] . ' ' . $contactFormData['lastName']
                . ' via Makesense';
            $content = '<h2>Bonjour,</h2>' . '<br><br><strong>' . $contactFormData['firstName'] . ' '
                . $contactFormData['lastName'] . '</strong>' . ' (' . $contactFormData['email'] . ') '
                . ' vous a envoyé un message concernant: <h3>' . $contactFormData['subject'] . ' :</h3>'
                . '"' . $contactFormData['message'] . '"';
            $mailer->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a bien été envoyé !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/contact_form.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
