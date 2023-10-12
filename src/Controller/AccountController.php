<?php

namespace App\Controller;


use App\Form\ChangeAdresseType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;





class AccountController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte", name="app_account")
     */
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    /**
     * @Route("/compte/modifierPassword", name="account_password")
     */
    public function changePassword(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $old_pwd = $form->get('old_password')->getData();

            if ($encoder->isPasswordValid($user, $old_pwd)) {

                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = 'Votre mot de passe a bien été mis à jour !!';
            } else {
                $notification = 'Votre mot de passe actuel n\'est pas le bon !!';
            }
            $form = $this->createForm(ChangePasswordType::class, $user);
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/compte/adresse", name="account_adress")
     */
    public function changeAdress(Request $request, UserRepository $userRepository): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangeAdresseType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldAddress = $form->get('old_adresse')->getData();
            $oldCp = $form->get('old_code_postal')->getData();

            if ($userRepository->findOneBy(['adresse' => $oldAddress]) && $userRepository->findOneBy(['code_postal' => $oldCp])) {
                $newAddress = $form->get('new_adresse')->getData();
                $newCp = $form->get('new_code_postal')->getData();

                $user->setAdresse($newAddress);
                $user->setCodePostal($newCp);

                $this->entityManager->persist($user);
                $this->entityManager->flush();


                $notification = 'Votre adresse a bien été mis à jour !!';
            } else {
                $notification = 'Votre adresse ou votre code postal actuel n\'est pas le bon !!';
            }

            $form = $this->createForm(ChangeAdresseType::class, $user);
        }

        return $this->render('account/adresse.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/compte/commande", name="account_commande")
     */
    public function commandes(): Response
    {
        $user = $this->getUser();
        $commandes = $this->entityManager->getRepository(Commande::class)->findCommandesByUser($user);

        return $this->render('account/commande.html.twig', [
            'commandes' => $commandes

        ]);
    }

    /**
     * @Route("/compte/commande/{id}", name="account_commande_show")
     */
    public function show($id): Response
    {

        $commande = $this->entityManager->getRepository(Commande::class)->findOneById($id);

        if (!$commande || $commande->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_commande');
        }



        return $this->render('account/commande_show.html.twig', [
            'commande' => $commande

        ]);
    }
}
