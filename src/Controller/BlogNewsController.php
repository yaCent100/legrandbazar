<?php

namespace App\Controller;

use App\Entity\BlogNews;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commentaires;
use App\Form\CommentairesType;
use Doctrine\ORM\EntityManagerInterface;



class BlogNewsController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/blog-news", name="app_blog")
     */
    public function index(): Response
    {
        // Récupérez les articles de blog à partir de la base de données
        $articles = $this->getDoctrine()->getRepository(BlogNews::class)->findAll();

        // Afficher la liste des articles de blog dans un template
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/blog-news/{id}", name="app_blog_show")
     */
    public function showArticle(Request $request, $id)
    {
        // Récupérer l'article correspondant à l'ID dans la base de données
        $article = $this->entityManager->getRepository(BlogNews::class)->find($id);

        // Créer un nouvel objet Comment pour le formulaire
        $comment = new Commentaires();
        $commentForm = $this->createForm(CommentairesType::class, $comment);

        // Traiter le formulaire s'il a été soumis
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            // Lier le commentaire à l'article et à l'utilisateur connecté
            $article->addCommentaire($comment);
            $comment->setUser($this->getUser());


            // Enregistrer le commentaire et l'article dans la base de données
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            // Rediriger vers la page de l'article
            return $this->redirectToRoute('app_blog_show', ['id' => $id]);
        }

        // Afficher le contenu de l'article et le formulaire de commentaire
        return $this->render('articles/article.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
