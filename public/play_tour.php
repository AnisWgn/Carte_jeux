<?php
// Endpoint API pour jouer un tour
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

session_start();

require_once '../src/Controller/BatailleController.php';
require_once '../src/fonctions.inc.php';

// Vérifier que la session est initialisée
if (!isset($_SESSION['partie_initialisee'])) {
    echo json_encode(['error' => 'Partie non initialisée']);
    exit;
}

// Vérifier qu'une carte a été choisie
if (!isset($_POST['carte_choisie'])) {
    echo json_encode(['error' => 'Aucune carte choisie']);
    exit;
}

try {
    // Réindexer la session pour correspondre aux indices du formulaire
    $_SESSION['jeu_joueur1'] = array_values($_SESSION['jeu_joueur1']);
    $_SESSION['jeu_joueur2'] = array_values($_SESSION['jeu_joueur2']);
    
    // Restaurer le contrôleur depuis la session
    $jeuJoueur1 = BatailleController::tableauxVersCartes($_SESSION['jeu_joueur1']);
    $jeuJoueur2 = BatailleController::tableauxVersCartes($_SESSION['jeu_joueur2']);
    
    $controller = new BatailleController();
    $controller->melangerJeu();
    $controller->distribuerJeu();
    $controller->setJeuJoueur1($jeuJoueur1);
    $controller->setJeuJoueur2($jeuJoueur2);
    $controller->setScores($_SESSION['score_joueur1'], $_SESSION['score_joueur2']);
    $controller->setHistorique($_SESSION['historique']);
    
    $indiceCarte = intval($_POST['carte_choisie']);
    $tourActuel = $_SESSION['tour_actuel'];
    
    // Vérifier que l'indice est valide
    if (!isset($_SESSION['jeu_joueur1'][$indiceCarte])) {
        echo json_encode(['error' => 'Carte invalide']);
        exit;
    }
    
    // Jouer le tour
    $resultat = $controller->jouerTourInteractif($indiceCarte, $tourActuel);
    
    // Convertir l'historique pour la session
    $historiqueSession = [];
    foreach ($controller->getHistoriqueTours() as $tour) {
        $carte1 = is_array($tour['carteJoueur1']) ? $tour['carteJoueur1'] : ['couleur' => $tour['carteJoueur1']->getCouleur(), 'figure' => $tour['carteJoueur1']->getFigure()];
        $carte2 = is_array($tour['carteJoueur2']) ? $tour['carteJoueur2'] : ['couleur' => $tour['carteJoueur2']->getCouleur(), 'figure' => $tour['carteJoueur2']->getFigure()];
        $historiqueSession[] = [
            'tour' => $tour['tour'],
            'carteJoueur1' => $carte1,
            'carteJoueur2' => $carte2,
            'resultat' => $tour['resultat']
        ];
    }
    
    // Mettre à jour la session
    $_SESSION['jeu_joueur1'] = array_values(BatailleController::cartesVersTableaux($controller->getJeuJoueur1()));
    $_SESSION['jeu_joueur2'] = array_values(BatailleController::cartesVersTableaux($controller->getJeuJoueur2()));
    $_SESSION['score_joueur1'] = $controller->getScoreJoueur1();
    $_SESSION['score_joueur2'] = $controller->getScoreJoueur2();
    $_SESSION['tour_actuel']++;
    $_SESSION['historique'] = $historiqueSession;
    
    // Préparer les données de réponse
    $carte1 = $resultat['carteJoueur1'];
    $carte2 = $resultat['carteJoueur2'];
    $res = $resultat['resultat'];
    
    // Vérifier si la partie est terminée
    $partieTerminee = count($_SESSION['jeu_joueur1']) == 0 || count($_SESSION['jeu_joueur2']) == 0;
    $gagnant = null;
    
    if ($partieTerminee) {
        $controllerFinal = new BatailleController();
        $controllerFinal->setScores($_SESSION['score_joueur1'], $_SESSION['score_joueur2']);
        $gagnant = $controllerFinal->getGagnant();
    }
    
    // Préparer les cartes restantes pour l'affichage
    $cartesRestantes = [];
    foreach ($_SESSION['jeu_joueur1'] as $index => $carteTab) {
        $carte = new Carte($carteTab['couleur'], $carteTab['figure']);
        $cartesRestantes[] = [
            'index' => $index,
            'nom' => $carte->getNom(),
            'image' => ObtenirImageCarte($carte),
            'isAtout' => $carte->isAtout()
        ];
    }
    
    // Retourner la réponse JSON
    echo json_encode([
        'success' => true,
        'resultat' => [
            'carteJoueur1' => [
                'nom' => $carte1->getNom(),
                'image' => ObtenirImageCarte($carte1),
                'isAtout' => $carte1->isAtout()
            ],
            'carteJoueur2' => [
                'nom' => $carte2->getNom(),
                'image' => ObtenirImageCarte($carte2),
                'isAtout' => $carte2->isAtout()
            ],
            'gagnant' => $res['gagnant'],
            'points' => $res['points'],
            'raison' => $res['raison'],
            'tour' => $_SESSION['tour_actuel'] - 1
        ],
        'scores' => [
            'joueur1' => $_SESSION['score_joueur1'],
            'joueur2' => $_SESSION['score_joueur2']
        ],
        'stats' => [
            'cartesRestantes' => count($_SESSION['jeu_joueur1']),
            'cartesRestantesJ2' => count($_SESSION['jeu_joueur2']),
            'tourActuel' => $_SESSION['tour_actuel']
        ],
        'cartesRestantes' => $cartesRestantes,
        'partieTerminee' => $partieTerminee,
        'gagnantFinal' => $gagnant
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

