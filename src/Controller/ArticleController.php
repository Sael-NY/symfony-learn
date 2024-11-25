<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

// Création de classe HomeController
class ArticleController extends AbstractController {

    // Le # est lu par PHP (commentaire like)
    // Une url '/' est lu par le router (accueil)
    #[Route('/articles', 'articles_list')]

    // je crée une méthode Home et ensuite une Response qui vient du Symfony qui permet de crée une reponse HTTP.
        // Et le HTML qui va avec
    public function article() {

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

return $this -> render('articles.html.twig', ['articles' => $articles]);
}

}