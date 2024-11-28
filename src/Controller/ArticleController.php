<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/article/create', 'create_article')]
    public function createArticle(EntityManagerInterface $entityManager): Response
    {
        // J'utilise un entité pour crée un article.
        $article = new Article();
        // J'utilse set + les méthodes pour remplir les propriétés
        $article->SetTitle('Title');
        $article->SetContent('Content');
        $article->setImage('image.jpg');
        $article->setCreatedAt(new \DateTime());

        // EntityManager sert a sauvegarder et supprimer les entités.
        // EntityManager et Doctrine sont liés et savent que l'entité 'article' elle est stockée dans la BDD
        // grâce aux annotations et donc l'entityManager sauvegarde l'entité.
        $entityManager->persist($article);

        // flush c'est comme un commit dans git, ça sert à executer une requete dans la BDD.
        $entityManager->flush();

        return new Response('Bonjour');
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
    public function updateArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response

    {
        // On récupère la variable qui stock tout articles et on modifie un article chacun si on veut.
        $article = $articleRepository->find($id);

        // On modifie les entités
        $article->SetTitle('Mleh');
        $article->SetContent('Bravo sahbi');

        // On fait une MAJ
        $entityManager->persist($article);
        // Et ensuite on passe une requete SQL
        $entityManager->flush();

        return $this->render('article_update.html.twig', [
            'article' => $article
        ]);
    }



}

