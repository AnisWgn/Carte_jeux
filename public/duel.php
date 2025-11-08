<?php
// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once '../src/Controller/BatailleController.php';
require_once '../src/fonctions.inc.php';

// Initialisation de la partie si nécessaire
if (!isset($_SESSION['partie_initialisee']) || isset($_GET['nouvelle_partie'])) {
    // Réinitialiser la session si demandé
    if (isset($_GET['nouvelle_partie'])) {
        session_destroy();
        session_start();
    }
    
    // Nouvelle partie
    $_SESSION['partie_initialisee'] = true;
    
    $controller = new BatailleController();
    $controller->melangerJeu();
    $couleurAtout = $controller->definirCouleurAtoutAuHasard();
    $controller->distribuerJeu();
    
    // Stocker les données en session
    $_SESSION['couleur_atout'] = $couleurAtout;
    $_SESSION['jeu_joueur1'] = BatailleController::cartesVersTableaux($controller->getJeuJoueur1());
    $_SESSION['jeu_joueur2'] = BatailleController::cartesVersTableaux($controller->getJeuJoueur2());
    $_SESSION['score_joueur1'] = 0;
    $_SESSION['score_joueur2'] = 0;
    $_SESSION['tour_actuel'] = 1;
    $_SESSION['historique'] = [];
    
    // Rediriger pour éviter la réinitialisation au rechargement
    if (isset($_GET['nouvelle_partie'])) {
        header('Location: duel.php');
        exit;
    }
}

// Récupérer les données de la session
$couleurAtout = $_SESSION['couleur_atout'];
Carte::setCouleurAtout($couleurAtout);

// Affichage de l'interface
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>BATAILLE INTERACTIVE</title>
    <link rel='stylesheet' href='assets/css/style.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>
    <div class='game-layout'>
        <!-- Panneau latéral gauche -->
        <div class='sidebar'>
            <!-- En-tête Big Blind -->
            <div class='big-blind-header'>
                <div class='big-blind-title'>Bataille</div>
                <div class='big-blind-badge'>
                    <div class='badge-icon'>⚔️</div>
                </div>
                <div class='big-blind-info'>
                    <div class='blind-label'>Couleur atout</div>
                    <div class='blind-value'><?php echo strtoupper($couleurAtout); ?></div>
                </div>
            </div>
            
            <!-- Scores des joueurs -->
            <div class='player-scores'>
                <div class='score-left'>
                    <div class='score-big' id='score-joueur1'><?php echo $_SESSION['score_joueur1']; ?></div>
                </div>
                <div class='vs-symbol'>✕</div>
                <div class='score-right'>
                    <div class='score-big' id='score-joueur2'><?php echo $_SESSION['score_joueur2']; ?></div>
                </div>
            </div>
            
            <!-- Stats -->
            <div class='stats-box'>
                <div class='stat-item'>
                    <div class='stat-label'>Mains</div>
                    <div class='stat-value' id='cartes-restantes'><?php echo count($_SESSION['jeu_joueur1']); ?></div>
                </div>
                <div class='stat-item'>
                    <div class='stat-label'>Tours</div>
                    <div class='stat-value' id='tour-actuel'><?php echo $_SESSION['tour_actuel']; ?></div>
                </div>
            </div>
            
            <!-- Total en or -->
            <div class='gold-total'>
                <div class='gold-symbol'>$</div>
                <div class='gold-amount' id='total-points'><?php echo $_SESSION['score_joueur1'] + $_SESSION['score_joueur2']; ?></div>
            </div>
            
            <!-- Ante et Round -->
            <div class='ante-round-box'>
                <div class='ante-item'>
                    <div class='ante-label'>Ante</div>
                    <div class='ante-value' id='ante-value'><?php echo count($_SESSION['jeu_joueur1']); ?>/<?php echo count($_SESSION['jeu_joueur1']) + count($_SESSION['jeu_joueur2']); ?></div>
                </div>
                <div class='ante-item'>
                    <div class='ante-label'>Round</div>
                    <div class='ante-value' id='round-value'><?php echo $_SESSION['tour_actuel']; ?></div>
                </div>
            </div>
            
            <!-- Boutons -->
            <div class='sidebar-buttons'>
                <a href='index.php'><button class='pixel-btn pixel-btn-red'>Accueil</button></a>
                <a href='?nouvelle_partie=1'><button class='pixel-btn pixel-btn-orange'>Nouvelle Partie</button></a>
            </div>
        </div>
        
        <!-- Zone de jeu principale -->
        <div class='main-area'>
            
            <div class='container' id='game-container'>
        
        <?php
        // Vérifier si la partie est terminée
        if (count($_SESSION['jeu_joueur1']) == 0 || count($_SESSION['jeu_joueur2']) == 0) {
            $controller = new BatailleController();
            $controller->setScores($_SESSION['score_joueur1'], $_SESSION['score_joueur2']);
            $gagnant = $controller->getGagnant();
            
            echo "<div class='partie-terminee'>";
            echo "<h1>PARTIE TERMINEE!</h1>";
            if ($gagnant == 1) {
                echo "<h2 class='winner-text'>VICTOIRE!</h2>";
            } elseif ($gagnant == 2) {
                echo "<h2 class='loser-text'>DEFAITE!</h2>";
            } else {
                echo "<h2 class='draw-text'>EGALITE!</h2>";
            }
            echo "<p><a href='?nouvelle_partie=1'><button>NOUVELLE PARTIE</button></a></p>";
            echo "</div>";
            session_destroy();
        } else {
            
            echo "<div id='resultat-tour-container'></div>";
            echo "<form id='card-select-form' class='card-select-form'>";
            foreach ($_SESSION['jeu_joueur1'] as $index => $carteTab) {
                $carte = new Carte($carteTab['couleur'], $carteTab['figure']);
                $imageCarte = ObtenirImageCarte($carte);
                $isAtout = $carte->isAtout() ? ' carte-atout' : '';
                echo "<label class='card-choice'>";
                echo "<input type='radio' name='carte_choisie' value='$index' required class='card-choice-input'>";
                echo "<img src='$imageCarte' alt='" . $carte->getNom() . "' class='card-choice-image$isAtout'>";
                if ($carte->isAtout()) {
                    echo "<span class='card-choice-badge'>*</span>";
                }
                echo "</label>";
            }
            echo "<button type='submit' class='btn-play' id='btn-play'>JOUER</button>";
            echo "</form>";
        }
        ?>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('card-select-form');
        const resultatContainer = document.getElementById('resultat-tour-container');
        const btnPlay = document.getElementById('btn-play');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const selectedCard = formData.get('carte_choisie');
                
                if (!selectedCard) {
                    alert('Veuillez choisir une carte');
                    return;
                }
                
                // Désactiver le bouton pendant le traitement
                if (btnPlay) {
                    btnPlay.disabled = true;
                    btnPlay.textContent = 'EN COURS...';
                }
                
                // Envoyer la requête AJAX
                fetch('play_tour.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Erreur: ' + data.error);
                        if (btnPlay) {
                            btnPlay.disabled = false;
                            btnPlay.textContent = 'JOUER';
                        }
                        return;
                    }
                    
                    // Afficher le résultat du tour
                    afficherResultatTour(data);
                    
                    // Mettre à jour les scores et stats
                    mettreAJourScores(data);
                    
                    // Vérifier si la partie est terminée
                    if (data.partieTerminee) {
                        afficherFinPartie(data);
                    } else {
                        // Mettre à jour les cartes disponibles
                        mettreAJourCartes(data.cartesRestantes);
                        
                        // Réactiver le formulaire après 2 secondes
                        setTimeout(function() {
                            if (btnPlay) {
                                btnPlay.disabled = false;
                                btnPlay.textContent = 'JOUER';
                            }
                            // Masquer le résultat après 3 secondes
                            setTimeout(function() {
                                resultatContainer.innerHTML = '';
                            }, 3000);
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue');
                    if (btnPlay) {
                        btnPlay.disabled = false;
                        btnPlay.textContent = 'JOUER';
                    }
                });
            });
        }
        
        function afficherResultatTour(data) {
            const resultat = data.resultat;
            let messageClass = 'egalite';
            let messageText = 'EGALITE! 0 POINTS';
            
            if (resultat.gagnant == 1) {
                messageClass = 'gagnant';
                messageText = 'VICTOIRE! +' + resultat.points + ' POINTS';
            } else if (resultat.gagnant == 2) {
                messageClass = 'perdant';
                messageText = 'DEFAITE! +' + resultat.points + ' POINTS';
            }
            
            const html = `
                <div class='resultat-tour'>
                    ${resultat.points > 0 ? '<div class="points-popup">+' + resultat.points + '</div>' : ''}
                    <h2>RESULTAT TOUR ${resultat.tour}</h2>
                    <div class='played-cards'>
                        <figure class='played-card'>
                            <figcaption class='played-card-title'>JOUEUR</figcaption>
                            <img src='${resultat.carteJoueur1.image}' alt='${resultat.carteJoueur1.nom}' class='played-card-image'>
                            ${resultat.carteJoueur1.isAtout ? '<span class="played-card-badge">*</span>' : ''}
                        </figure>
                        <figure class='played-card'>
                            <figcaption class='played-card-title'>ORDI</figcaption>
                            <img src='${resultat.carteJoueur2.image}' alt='${resultat.carteJoueur2.nom}' class='played-card-image'>
                            ${resultat.carteJoueur2.isAtout ? '<span class="played-card-badge">*</span>' : ''}
                        </figure>
                    </div>
                    <div class='resultat-message ${messageClass}'>${messageText}</div>
                </div>
            `;
            
            resultatContainer.innerHTML = html;
        }
        
        function mettreAJourScores(data) {
            const scoreJ1 = document.getElementById('score-joueur1');
            const scoreJ2 = document.getElementById('score-joueur2');
            const totalPoints = document.getElementById('total-points');
            const cartesRestantes = document.getElementById('cartes-restantes');
            const tourActuel = document.getElementById('tour-actuel');
            const anteValue = document.getElementById('ante-value');
            const roundValue = document.getElementById('round-value');
            
            if (scoreJ1) scoreJ1.textContent = data.scores.joueur1;
            if (scoreJ2) scoreJ2.textContent = data.scores.joueur2;
            if (totalPoints) totalPoints.textContent = data.scores.joueur1 + data.scores.joueur2;
            if (cartesRestantes) cartesRestantes.textContent = data.stats.cartesRestantes;
            if (tourActuel) tourActuel.textContent = data.stats.tourActuel;
            if (anteValue) anteValue.textContent = data.stats.cartesRestantes + '/' + (data.stats.cartesRestantes + data.stats.cartesRestantesJ2);
            if (roundValue) roundValue.textContent = data.stats.tourActuel;
        }
        
        function mettreAJourCartes(cartes) {
            const form = document.getElementById('card-select-form');
            if (!form) return;
            
            // Réinitialiser le formulaire
            form.reset();
            
            // Supprimer les anciennes cartes (sauf le bouton)
            const labels = form.querySelectorAll('.card-choice');
            labels.forEach(label => label.remove());
            
            // Ajouter les nouvelles cartes
            const btnPlay = document.getElementById('btn-play');
            cartes.forEach(carte => {
                const label = document.createElement('label');
                label.className = 'card-choice';
                
                const input = document.createElement('input');
                input.type = 'radio';
                input.name = 'carte_choisie';
                input.value = carte.index;
                input.required = true;
                input.className = 'card-choice-input';
                
                const img = document.createElement('img');
                img.src = carte.image;
                img.alt = carte.nom;
                img.className = 'card-choice-image' + (carte.isAtout ? ' carte-atout' : '');
                
                label.appendChild(input);
                label.appendChild(img);
                
                if (carte.isAtout) {
                    const badge = document.createElement('span');
                    badge.className = 'card-choice-badge';
                    badge.textContent = '*';
                    label.appendChild(badge);
                }
                
                form.insertBefore(label, btnPlay);
            });
        }
        
        function afficherFinPartie(data) {
            const container = document.getElementById('game-container');
            let gagnantText = 'EGALITE!';
            let gagnantClass = 'draw-text';
            
            if (data.gagnantFinal == 1) {
                gagnantText = 'VICTOIRE!';
                gagnantClass = 'winner-text';
            } else if (data.gagnantFinal == 2) {
                gagnantText = 'DEFAITE!';
                gagnantClass = 'loser-text';
            }
            
            const html = `
                <div class='partie-terminee'>
                    <h1>PARTIE TERMINEE!</h1>
                    <h2 class='${gagnantClass}'>${gagnantText}</h2>
                    <p><a href='?nouvelle_partie=1'><button>NOUVELLE PARTIE</button></a></p>
                </div>
            `;
            
            container.innerHTML = html;
        }
    });
    </script>
</body>
</html>

