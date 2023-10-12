<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;




class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Commandes')
            ->setPageTitle(Crud::PAGE_DETAIL, 'Détails de la commande');
    }


    public function configureFields(string $pageName): iterable
    {


        return [


            AssociationField::new('user', 'User')
                ->setFormTypeOption('choice_label', 'pseudo'),

            DateTimeField::new('creatAt', 'Passée le')
                ->setFormat('dd/MM/yyyy HH:mm:ss'),

            NumberField::new('prixTotal', 'Total')
                ->setNumDecimals(2)


        ];
    }

    public function configureActions(Actions $actions): Actions
    {

        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);

        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        return $actions;
    }

    public function detail(AdminContext $context)
    {
        $id = $context->getRequest()->query->get('entityId');
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);

        if (!$commande) {
            throw $this->createNotFoundException(sprintf('La commande avec l\'id "%s" n\'existe pas.', $id));
        }

        // Récupérer les produits de toutes les factures associées à cette commande
        $produits = [];

        foreach ($commande->getFactures() as $facture) {
            foreach ($facture->getProduit() as $Product) {
                $produit = $Product->getName();
                $prixUnitaire = $Product->getPrice();
                $quantite = $facture->getQuantity();

                $prixTotal = $quantite * $prixUnitaire;

                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'prixUnitaire' => $prixUnitaire,
                    'prixTotal' => $prixTotal
                ];
            }
        }




        return $this->render('admin/details.html.twig', [
            'commande' => $commande,
            'produits' => $produits,


        ]);
    }
}
