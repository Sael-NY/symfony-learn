<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{#[Route('/contact', name: 'contact', methods: ['POST']) ]
public function contact(Request $request): Response
{

    // Initialiser la variable pour éviter des erreurs
    $messageEnv = null; // Initialiser la variable pour éviter des erreurs
    $contact = null;

    // Vérifier si la requête est en POST
    if ($request->isMethod('POST')) {
        // Récupérer le paramètre "contact"
        $contact = $request->request->get('contact');
        // Récupérer le champ "name"
        $name = $request->request->get('name');
        // Récupérer le champ "message"
        $message = $request->request->get('message');
        // Message de confirmation
        $messageEnv = "Merci à toi jeune entrepreneur" . $name . "Votre message :" . $message;

    }

    return $this->render('contact.html.twig', [
        'contact' => $contact,
        // Ajouter le message dans la vue
        'messageEnv' => $messageEnv,
    ]);
}
}