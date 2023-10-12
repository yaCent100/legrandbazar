<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Cart;
use App\Entity\Commande;
use App\Entity\Facture;
use \DateTime;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CommandeController extends AbstractController
{



    /**
     * @Route("mon-panier/commande", name="commande")
     */
    public function index(Cart $cart): Response
    {
        return $this->render('commande/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/mon-panier/commande/confirmation", name="confirmation", methods={"POST"})
     */
    public function confirmation(Cart $cart, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        // Récupérer l'utilisateur actuel
        $user = $this->getUser();

        // Créer une nouvelle commande
        $commande = new Commande();
        $commande->setUser($user);
        $commande->setCreatAt(new \DateTime());

        // Ajouter chaque produit dans une nouvelle facture
        $prixTotal = 0;
        foreach ($cart->getFull() as $produit) {
            $facture = new Facture();
            $facture->setCommande($commande);
            $facture->addProduit($produit['product']);
            $facture->setQuantity($produit['quantity']);
            $facture->setPrixLigne($produit['product']->getPrice() * $produit['quantity'] / 100);


            $entityManager->persist($facture);

            $prixTotal += $facture->getPrixLigne();
        }

        // Ajouter le prix total à la commande
        $commande->setPrixTotal($prixTotal);

        // Enregistrer la commande en base de données
        $entityManager->persist($commande);
        $entityManager->flush();

        // Vider le panier
        $session->remove('cart');

        // Rediriger vers la page de confirmation de commande
        return $this->render('commande/confirmation.html.twig');
    }
}
