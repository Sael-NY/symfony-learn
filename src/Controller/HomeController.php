<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe HomeController
class HomeController extends AbstractController {

    // Le # est lu par PHP (commentaire like)
    // Une url '/' est lu par le router (accueil)
    #[Route('/', 'home')]

        // je crée une méthode Home et ensuite une Response qui vient du Symfony qui permet de crée une reponse HTTP.
        // Et le HTML qui va avec
    public function home() {

    return $this -> render('home.html.twig');
    }



}