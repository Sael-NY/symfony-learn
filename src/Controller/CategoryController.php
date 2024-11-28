<?php

namespace App\Controller;

use App\Entity\Category;
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

    #[Route('/category/create', 'create_category')]
    public function createCategory(EntityManagerInterface $entityManager): Response
    {
        // J'utilise un entité pour crée une catégorie.
        $category = new Category();
        // J'utilse set + les méthodes pour remplir les propriétés
        $category->SetTitle('Arbre');
        $category->SetColor('Marron');

        // EntityManager sert a sauvegarder et supprimer les entités.
        // EntityManager et Doctrine sont liés et savent que l'entité 'catégorie' elle est stockée dans la BDD
        // grâce aux annotations et donc l'entityManager sauvegarde l'entité.
        $entityManager->persist($category);

        // flush c'est comme un commit dans git, ça sert à executer une requete dans la BDD.
        $entityManager->flush();

        return $this->render('category_create.html.twig',
            // C'est un tableau qui contient les variables articles (twig)
            ['category' => $category]);
    }


}