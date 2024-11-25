<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe HomeController
class PokerController extends AbstractController {

    #[Route('/poker', 'poker')]
    public function poker () {
    // Cette méthode permet de remplir la variable $request avec toutes
        // les données de requête (GET, POST, SESSION, addresse IP etc)
        $request = Request::createFromGlobals();
        //Récupère le donnée GET
        $age = $request->query->get('age');




        if($age >= 18) {
            return $this->render('poker.html.twig');
        } else {
            return $this->render('pokererror.html.twig');
        }
        var_dump($age); die;


    return new Response('Bienvenue sur la page poker');
    }
}
?>
