<?php

namespace App\Classe;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id)
    {
        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id]) && ($cart[$id] < 10)) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }


        $this->session->set('cart', $cart);
    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id)
    {
        $cart = $this->session->get('cart');

        unset($cart[$id]);

        return $this->session->set('cart', $cart);
    }

    public function decrease($id)
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id] > 1) {
            //retirer une quantité -1
            $cart[$id]--;
        } else {
            //supprimer mon produit
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);
    }

    public function getFull()
    {
        $cartComplete = [];

        //dés que tu a des produits tu fais le foreach
        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product =  $this->entityManager->getRepository(Product::class)->findOneById($id);

                if (!$product) {
                    $this->delete($id);
                    continue;
                }


                $cartComplete[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }
}
