<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;





class HomeController extends AbstractController
{



    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {


        // Gérer la soumission du formulaire de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($request->isMethod('POST')) {
            // Récupérer les données du formulaire de connexion
            $pseudo = $request->request->get('pseudo');
            $password = $request->request->get('password');

            // Valider les données de connexion
            $user = $entityManager->getRepository(User::class)->findOneBy(['pseudo' => $pseudo]);

            if (!$user) {
                $error = 'Ce pseudo ou ce mot de passe ne sont pas valide !!';
            } else {
                $passwordEncoder = $this->get('security.password_encoder');
                $isValidPassword = $passwordEncoder->isPasswordValid($user, $password);

                if ($isValidPassword) {
                    // Connecter l'utilisateur
                    $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                    $this->get('security.token_storage')->setToken($token);






                    return $this->redirectToRoute('app_home');
                } else {
                    $error = 'Ce pseudo ou ce mot de passe ne sont pas valide !!';
                }
            }
        }

        return $this->render('home/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
