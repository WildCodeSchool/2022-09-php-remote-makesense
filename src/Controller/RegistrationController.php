<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserAvatar;
use App\Form\RegistrationFormType;
use App\Repository\EmployeeRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
        EmployeeRepository $employeeRepository,
        MailerInterface $mailer
    ): Response {
        $user = new User();
//        $avatar = new UserAvatar();
//        $user->setAvatar($avatar);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $email = $user->getEmail();
            $firstName = $user->getFirstName();
            $lastName = $user->getLastName();

            $employee = $employeeRepository->findOneByForm($email, $firstName, $lastName);
            if ($employee) {
                $entityManager->persist($user);
                $entityManager->flush();
                $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, (
                new TemplatedEmail())
                    ->from(new Address('mailer@makesense.wild.com', 'MakeSense'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre adresse mail')
                    ->htmlTemplate('registration/confirmation_email.html.twig'));

                $this->addFlash('success', 'Vous avez reçu un email pour valider votre compte');

                return $this->redirectToRoute('app_home');
            } else {
                $email = (new Email())
                    ->from('makesense@makesense.com')
                    ->to('admin@makesense.com')
                    ->subject('Demande de création de compte')
                    ->html($this->renderView('registration/admin_verification_user.html.twig', [
                        'user' => $user]));

                $mailer->send($email);

                return $this->redirectToRoute('app_register_pending');
            }
        }
        return $this->render('registration/register.html.twig', [
            'registrationFormType' => $form->createView(),
        ]);
    }
    #[Route('/register/pending', name: 'app_register_pending')]
    public function pendingMessage(): Response
    {
        return $this->render('registration/waiting_verification_email.html.twig');
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            /**  @var User $user */
            $user = $this->getUser();
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Votre adresse mail a bien été validée.');

        return $this->redirectToRoute('app_home');
    }
}
