<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe HomeController
class HomeController

    // Le # est lu par PHP (commentaire like)
    // Une url '/' est lu par le router (accueil)
    #[Route('/', 'home')]
    // je créé une méthode home
        // qui retourne une instance de la classe
        // Response (issue de Symfony)
        // la classe permet créé une réponse HTTP valide (avec un status etc)
        // et prend en parametre le HTML à envoyer au navigateur

        // je crée une méthode Home et ensuite une Response qui vient du Symfony qui permet de crée une reponse HTTP.
        // Et le HTML qui va avec
    public function home() {
        return new Response('<h1>Page Accueil</h1>');
    };


}