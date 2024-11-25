<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// je créé une classe HomeController
class HomeController
{
    // je créé une route pour ma méthode home
    // ça veut dire que pour l'url "/",
    // c'est ma méthode de controleur située
    // juste dessous /qui est appélée
    // le # est une annotation en PHP (une sorte de
    // commentaire lu et utilisé par PHP)
    #[Route('/', 'home')]
    // je créé une méthode home
        // qui retourne une instance de la classe
        // Response (issue de Symfony)
        // la classe permet créé une réponse HTTP valide (avec un status etc)
        // et prend en parametre le HTML à envoyer au navigateur
    public function home() {
        return new Response('<h1>Page Accueil</h1>');
    }


}