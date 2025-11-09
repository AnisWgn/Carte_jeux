<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Définir le header JSON
header('Content-Type: application/json');

// Vérifier que la session est initialisée
if (!isset($_SESSION['partie_initialisee'])) {
    echo json_encode(['error' => 'Partie non initialisée']);
    exit;
}

// Vérifier que la carte a été choisie
if (!isset($_POST['carte_choisie'])) {
    echo json_encode(['error' => 'Aucune carte choisie']);
    exit;
}

require_once '../src/Controller/BatailleController.php';
require_once '../src/fonctions.inc.php';

try {
    // Récupérer les données de la session
    $couleurAtout = $_SESSION['couleur_atout'];
    $jeuJoueur1 = $_SESSION['jeu_joueur1'];
    $jeuJoueur2 = $_SESSION['jeu_joueur2'];
    $scoreJoueur1 = $_SESSION['score_joueur1'];
    $scoreJoueur2 = $_SESSION['score_joueur2'];
    $tourActuel = $_SESSION['tour_actuel'];
    
    // Définir la couleur atout
    Carte::setCouleurAtout($couleurAtout);
    
    // Convertir les tableaux de cartes en objets Carte
    $cartesJoueur1 = BatailleController::tableauxVersCartes($jeuJoueur1);
    $cartesJoueur2 = BatailleController::tableauxVersCartes($jeuJoueur2);
    
    // Créer le contrôleur et charger les données
    $controller = new BatailleController();
    $controller->setJeuJoueur1($cartesJoueur1);
    $controller->setJeuJoueur2($cartesJoueur2);
    $controller->setScores($scoreJoueur1, $scoreJoueur2);
    
    // Récupérer l'indice de la carte choisie
    $indiceCarteChoisie = (int)$_POST['carte_choisie'];
    
    // Jouer le tour (cette méthode met déjà à jour les scores)
    $resultatTour = $controller->jouerTourInteractif($indiceCarteChoisie, $tourActuel);
    
    // Vérifier si la partie est terminée
    $partieTerminee = $controller->estPartieTerminee();
    
    // Préparer les données de réponse
    $carteJ1 = $resultatTour['carteJoueur1'];
    $carteJ2 = $resultatTour['carteJoueur2'];
    $resultat = $resultatTour['resultat'];
    
    // Obtenir les images des cartes
    $imageCarteJ1 = ObtenirImageCarte($carteJ1);
    $imageCarteJ2 = ObtenirImageCarte($carteJ2);
    
    // Préparer les cartes restantes pour le joueur 1
    $cartesRestantes = [];
    $jeuJoueur1Restant = $resultatTour['jeuJoueur1'];
    foreach ($jeuJoueur1Restant as $index => $carte) {
        $cartesRestantes[] = [
            'index' => $index,
            'image' => ObtenirImageCarte($carte),
            'nom' => $carte->getNom(),
            'isAtout' => $carte->isAtout()
        ];
    }
    
    // Ajouter à l'historique
    if (!isset($_SESSION['historique'])) {
        $_SESSION['historique'] = [];
    }
    $_SESSION['historique'][] = [
        'tour' => $tourActuel,
        'carteJoueur1' => [
            'image' => $imageCarteJ1,
            'nom' => $carteJ1->getNom(),
            'isAtout' => $carteJ1->isAtout()
        ],
        'carteJoueur2' => [
            'image' => $imageCarteJ2,
            'nom' => $carteJ2->getNom(),
            'isAtout' => $carteJ2->isAtout()
        ],
        'gagnant' => $resultat['gagnant'],
        'points' => $resultat['points']
    ];
    
    // Mettre à jour la session
    $_SESSION['jeu_joueur1'] = BatailleController::cartesVersTableaux($resultatTour['jeuJoueur1']);
    $_SESSION['jeu_joueur2'] = BatailleController::cartesVersTableaux($resultatTour['jeuJoueur2']);
    $_SESSION['score_joueur1'] = $controller->getScoreJoueur1();
    $_SESSION['score_joueur2'] = $controller->getScoreJoueur2();
    $_SESSION['tour_actuel'] = $tourActuel + 1;
    
    // Préparer la réponse JSON
    $response = [
        'resultat' => [
            'tour' => $tourActuel,
            'carteJoueur1' => [
                'image' => $imageCarteJ1,
                'nom' => $carteJ1->getNom(),
                'isAtout' => $carteJ1->isAtout()
            ],
            'carteJoueur2' => [
                'image' => $imageCarteJ2,
                'nom' => $carteJ2->getNom(),
                'isAtout' => $carteJ2->isAtout()
            ],
            'gagnant' => $resultat['gagnant'],
            'points' => $resultat['points']
        ],
        'scores' => [
            'joueur1' => $controller->getScoreJoueur1(),
            'joueur2' => $controller->getScoreJoueur2()
        ],
        'stats' => [
            'cartesRestantes' => count($resultatTour['jeuJoueur1']),
            'cartesRestantesJ2' => count($resultatTour['jeuJoueur2']),
            'tourActuel' => $tourActuel + 1
        ],
        'cartesRestantes' => $cartesRestantes,
        'partieTerminee' => $partieTerminee,
        'historique' => $_SESSION['historique']
    ];
    
    // Déterminer le gagnant final si la partie est terminée
    if ($partieTerminee) {
        $response['gagnantFinal'] = $controller->getGagnant();
    }
    
    // Retourner la réponse JSON
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

