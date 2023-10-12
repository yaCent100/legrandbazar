<?php

namespace App\Controller\Admin;


use App\Entity\BlogNews;
use App\Entity\Category;
use App\Entity\Commentaires;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Commande;
use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function GuzzleHttp\Promise\settle;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Le Grand b@z@r');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Home', 'fas fa-home', '/');

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-tachometer');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-tag', Product::class);
        yield MenuItem::linkToCrud('Commandes',  'fa fa-shopping-basket', Commande::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', BlogNews::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Commentaires::class);
        yield MenuItem::linkToCrud('MessagesChat', 'fas fa-regular fa-comments', Message::class);
        yield MenuItem::linkToRoute('Connexions', 'fas fa-link', 'app_connexion');
    }
}
