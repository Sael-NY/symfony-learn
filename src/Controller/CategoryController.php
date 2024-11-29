<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe CategoryController
class CategoryController extends AbstractController
{

    // Le # est lu par PHP (commentaire like)
    // Une url '/category' est lu par le router
    #[Route('/category', 'category_list')]
    // je crée une méthode Category..
    // Repository est une classe qui permet d'aller chercher dans une base de données.
    public function categorys(CategoryRepository $categoryRepository): Response
    {
    // Prend toutes la table category dans la base de données pour en faire une variable.
        $categorys = $categoryRepository->findAll();
        // Et le HTML qui va avec
        return $this->render('category.html.twig', ['categorys' => $categorys]);
    }

    // Le # est lu par PHP (commentaire like)
    // Une url '/category/{id}' est lu par le router
    #[Route('/category/{id}', 'category_show', requirements: ['id' => '\d+'])]
    // Crée une méthode qui prend en paramétre un article en particulier (id), et repository en mot clé (BDD)
        // pour condenser le code.
    public function showCategory($id, CategoryRepository $categoryRepository) : Response
    {
        // Prend toutes la table category dans la BDD et pour en piocher un article si on veut.
        $categorys = $categoryRepository->find($id);


        // Je crée une réponse HTTP via le twig, render du parent AbstractController qui prend un fichier twig
        return $this->render('category_show.html.twig',
            // C'est un tableau qui contient les variables articles (twig)
            ['category' => $categorys]);
    }

    // Le # est lu par PHP (commentaire like)
    // Une url '/' est lu par le router
    #[Route('/category/create', 'create_category')]
    // je crée une méthode Create, et symfony prend en charge de créer l'article en question, et d'affichez une réponse HTML
        // comme quoi c'est créé.
    public function createCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            // Récupérer le paramètre "title"
            $title = $request->request->get('title');
            // Récupérer le champ "color"
            $color = $request->request->get('color');

            // J'utilise un entité pour crée une catégorie.
        $category = new Category();
        // J'utilse set + les méthodes pour remplir les propriétés
        $category->SetTitle($title);
        $category->SetColor($color);

        // EntityManager sert a sauvegarder et supprimer les entités.
        // EntityManager et Doctrine sont liés et savent que l'entité 'catégorie' elle est stockée dans la BDD
        // grâce aux annotations et donc l'entityManager sauvegarde l'entité.
        $entityManager->persist($category);

        // flush c'est comme un commit dans git, ça sert à executer une requete dans la BDD.
        $entityManager->flush();

        return $this->redirectToRoute('category_list');
    }
        return $this->render('category_create.html.twig',
            // C'est un tableau qui contient les variables category (twig)
            []);
    }

    #[Route('/category/delete/{id}', 'delete_category', ['id' => '\d+'])]
    // je crée une méthode Delete, et symfony prend en charge de supprimer category en question, et d'affichez une réponse HTML
        // comme quoi c'est supprimée.
    public function deleteCategory(int $id, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        // On utilise la variable pour stocker les articles et on choisit lequel qu'on vouldra supprimer.
        $category = $categoryRepository->find($id);
        // Si on raffraichit 2 fois ou plus, ça redirige 'not_found' comme quoi c'est bien supprimé.
        if (!$category) {
            return $this->redirectToRoute('not_found');
        }

        // On supprime category
        $entityManager->remove($category);
        // Et on passe dans une requete SQL
        $entityManager->flush();
        return $this->render('category_delete.html.twig',
            ['category' => $category]);
    }
    // Le # est lu par PHP (commentaire like)
#[Route('/category/update/{id}', 'update_category', ['id' => '\d+'])]
// Encore une fois on crée un updateArticle, et symfony prend en charge de modifier un category en
        // question, et d'afficher une reponse HTML comme quoi c'est modifié.
    public function updateCategory(int $id,CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = $categoryRepository->find($id);
        $message = null;

        // Vérifier si la requête est en POST
        if ($request->isMethod('POST')) {
            // Récupérer le paramètre "title"
            $title = $request->request->get('title');
            // Récupérer le champ "content"
            $color = $request->request->get('color');

            // Avoir un titre qui est dans le form
            $category->setTitle($title);
            // Définit le contenu de l'article
            $category->setColor($color);

            // EntityManager sert a sauvegarder et supprimer les entités.
            // EntityManager et Doctrine sont liés et savent que l'entité 'catégorie' elle est stockée dans la BDD
            // grâce aux annotations et donc l'entityManager sauvegarde l'entité.
            $entityManager->persist($category);
            // On passe au requete SQL comme un commit dans github
            $entityManager->flush();

            $message = "La catégorie '" . $category->getTitle() . "' a bien été mis à jour";

        }

        return $this->render('category_update.html.twig', [
            'category' => $category,
            'message' => $message
        ]);
    }
}