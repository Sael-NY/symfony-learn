<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe HomeController
class ArticleController extends AbstractController
{

    // Le # est lu par PHP (commentaire like)
    // Une url '/' est lu par le router (accueil)
    #[Route('/articles', 'articles_list')]
    // je crée une méthode Home et ensuite une Response qui vient du Symfony qui permet de crée une reponse HTTP.
        // Et le HTML qui va avec
    public function articles(ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findAll();

        return $this->render('articles.html.twig', ['articles' => $articles]);
    }

//Je crée une URL avec un {id} qui marche avec "/article/..."
    #[Route('/articles/{id}', 'article_show', ['id' => '\d+'])]
    // je passe en paramétre de la méthode $id , et en symfony s'occupe du stockage de l'id et la
        // mise en page de l'url
    public function showArticle($id, ArticleRepository $articleRepository) : Response
    {
        $articles = $articleRepository->find($id);


        // Je crée une réponse HTTP via le twig, render du parent AbstractController qui prend un fichier twig
        return $this->render('article_show.html.twig',
            // C'est un tableau qui contient les variables articles (twig)
            ['article' => $articles]);
    }
    #[Route('/articles/search-results', 'article_search')]
    // Pas besoin d'instancier manuellement un $request, je peux faire via Symfony pour que ça soit
    // automatiquement pour stocker la varibale derrière une classe voulue.
    // Ce mécanisme est appelé autowire
    public function searchArticle(Request $request): Response
    {

        $search = $request->query->get('search');
        return $this->render('article_search.html.twig', [
            'search' => $search
        ]);
    }

}

