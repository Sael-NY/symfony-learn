<?php

namespace App\Controller;

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
    public function articles(): Response
    {

        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ]

        ];

        return $this->render('articles.html.twig', ['articles' => $articles]);
    }

//Je crée une URL avec un {id} qui marche avec "/article/..."
    #[Route('/articles/{id}', 'article_show', ['id' => '\d+'])]
    // je passe en paramétre de la méthode $id , et en symfony s'occupe du stockage de l'id et la
        // mise en page de l'url
    public function showArticle($id) : Response
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ]

        ];
// je crée un article dans une variable null pour la retrouver
        $articleFound = null;

// Chaque article on lui donne un id pour enfin les retrouver et je stocke dans ma variable
        foreach ($articles as $article) {
            if ($article['id'] === (int)$id) {
                $articleFound = $article;
            }
        }

        if(!$articleFound) {
            return $this->redirectToRoute('not_found');
        }

        // Je crée une réponse HTTP via le twig, render du parent AbstractController qui prend un fichier twig
        return $this->render('article_show.html.twig',
            // C'est un tableau qui contient les variables articles (twig)
            ['article' => $articleFound]);
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

