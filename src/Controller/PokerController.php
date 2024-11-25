<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Création de classe HomeController
class PokerController {

    #[Route('/poker', 'poker')]
    public function poker () {
    // Cette méthode permet de remplir la variable $request avec toutes
        // les données de requête (GET, POST, SESSION, addresse IP etc)
        $request = Request::createFromGlobals();
        //Récupère le donnée GET
        $age = $request->query->get('age');

        $age = 16;

if ($age >= 18) {
    echo "Accès autorisé.";
} else {
    echo "Accès refusé. Vous devez avoir au moins 18 ans.";
};
        var_dump($age); die;


    return new Response('Bienvenue sur la page poker');
    }
}
?>
