<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe ArticleController
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
    public function showArticle($id, Request $request,ArticleRepository $articleRepository) : Response
    {
        $articles = $articleRepository->find($id);

        // ajouter le formulaire et le passer à la vue
        // Créé un article
        $comment = new Comment();
        // On utilise un variable qui contient la classe createForm qui vient d'AbstractController
        // et qui gère une form du côté HTML.
        $form = $this->createForm(ArticleType::class, $articles);
        // il gère le côté HTTP et de demander à chaque enregistrement et de remplir à chaque input et stocker (title,content...)
        $form -> handleRequest($request);
        // Et j'affiche en view pour le côté client
        $formView = $form->createView();

        // Je crée une réponse HTTP via le twig, render du parent AbstractController qui prend un fichier twig
        return $this->render('article_show.html.twig',
            // C'est un tableau qui contient les variables articles (twig)
            ['article' => $articles
            , 'comment' => $comment
            , 'formView' => $formView]);
    }
    #[Route('/articles/search-results', 'search_results')]
    // Pas besoin d'instancier manuellement un $request, je peux faire via Symfony pour que ça soit
    // automatiquement pour stocker la varibale derrière une classe voulue.
    // Ce mécanisme est appelé autowire
    public function searchArticle(Request $request, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {

        $search = $request->query->get('search');

        $articles = $articleRepository->search($search);
        $categories = $categoryRepository->search($search);



        return $this->render('article_search.html.twig', [
            'search' => $search,
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
    #[Route('/article/create', 'create_article')]
    // je crée une méthode Create, et symfony prend en charge de créer l'article en question, et d'affichez une réponse HTML
        // comme quoi c'est supprimée.
    public function createArticle(Request $request,EntityManagerInterface $entityManager): Response
    {
        // Créé un article
        $article = new Article();
        // On utilise un variable qui contient la classe createForm qui vient d'AbstractController
        // et qui gère une form du côté HTML.
        $form = $this->createForm(ArticleType::class, $article);
        // il gère le côté HTTP et de demander à chaque enregistrement et de remplir à chaque input et stocker (title,content...)
        $form -> handleRequest($request);
        // Et j'affiche en view pour le côté client
        $formView = $form->createView();

        // Vérification de données envoyées
        if ($form -> isSubmitted()) {
            // Création de la date une fois que c'est créé
        $article ->setCreatedAt(new \DateTime());
        // On sauvegarde tout ça
        $entityManager->persist($article);
            // Et on passe dans une requete SQL
        $entityManager->flush();
    }


        return $this -> render('article_create.html.twig', [
            'formView' => $formView,
        ]);
    }
    // Le # est lu par PHP (commentaire like)
    #[Route('/article/delete/{id}', 'delete_article', ['id' => '\d+'])]
    // je crée une méthode Delete, et symfony prend en charge de supprimer l'article en question, et d'affichez une réponse HTML
        // comme quoi c'est supprimée.
    public function deleteArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response
    {
        // On utilise la variable pour stocker les articles et on choisit lequel qu'on vouldra supprimer.
        $article = $articleRepository->find($id);
        // Si on raffraichit 2 fois ou plus, ça redirige 'not_found' comme quoi c'est bien supprimé.
        if (!$article) {
            return $this->redirectToRoute('not_found');
        }

        // On supprime l'article
        $entityManager->remove($article);
        // Et on passe dans une requete SQL
        $entityManager->flush();
    return $this->render('article_delete.html.twig',
        ['article' => $article]);
    }

    // Le # est lu par PHP (commentaire like)
#[Route('/article/update/{id}', 'update_article', ['id' => '\d+'])]
// Encore une fois on crée un updateArticle, et symfony prend en charge de modifier l'article en
    // question, et d'afficher une reponse HTML comme quoi c'est modifié.
    public function updateArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository, Request $request): Response
    {
        $article = $articleRepository->find($id);

        // Vérifier si la requête est en POST
        if ($request->isMethod('POST')) {
            // Récupérer le paramètre "title"
            $title = $request->request->get('title');
            // Récupérer le champ "content"
            $content = $request->request->get('content');
            // Récupérer le champ "image"
            $image = $request->request->get('image');


            // Avoir un titre qui est dans le form
            $article->setTitle($title);
            // Définit le contenu de l'article
            $article->setContent($content);
            // Avoir une image dans l'article
            $article->setImage($image);


            // EntityManager sert a sauvegarder et supprimer les entités.
            // EntityManager et Doctrine sont liés et savent que l'entité 'catégorie' elle est stockée dans la BDD
            // grâce aux annotations et donc l'entityManager sauvegarde l'entité.
            $entityManager->persist($article);
            // On passe au requete SQL comme un commit dans github
            $entityManager->flush();

            $message = "L'article '" . $article->getTitle() . "' a bien été mis à jour";

        }

        return $this -> render('article_update.html.twig', [
            'article' => $article,
            'message' => $message
        ]);
    }




}

