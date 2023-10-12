<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use App\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Commande;




/**
 * @ORM\Entity(repositoryClass=FactureRepository::class)
 */
class Facture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne (targetEntity=commande::class, inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)

     */
    private $commande;

    /**
     * @ORM\ManyToMany(targetEntity=product::class, inversedBy="factures")
     */
    private $produit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prixLigne;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?commande
    {
        return $this->commande;
    }

    public function setCommande(?commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }



    public function addProduit(Product $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Product $produit): self
    {
        $this->produit->removeElement($produit);

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrixLigne(): ?string
    {
        return $this->prixLigne;
    }

    public function setPrixLigne(string $prixLigne): self
    {
        $this->prixLigne = $prixLigne;

        return $this;
    }
}
