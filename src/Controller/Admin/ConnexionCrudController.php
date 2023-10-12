<?php

namespace App\Controller\Admin;

use App\Entity\Connexion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use App\Entity\User;
use Doctrine\ORM\createQueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class ConnexionCrudController extends AbstractCrudController
{


    public static function getEntityFqcn(): string
    {
        return Connexion::class;
    }







    /**
     * @Route("/admin/connexions", name="app_connexion")
     */
    public function customPage(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $content = $this->renderView('admin/connexions.html.twig', [
            'users' => $users,

        ]);
        return new Response($content);
    }
}
