<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Ludos - Boutique</title>
    <link rel='stylesheet' href='assets/css/style-accueil.css'>
    <link rel='stylesheet' href='assets/css/style-boutique.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body>





    <div class='boutique-container'>
        <!-- En-tête -->
        <header class='header'>
            <div class='title-container'>
                <h1 class='main-title'>🛒 BOUTIQUE</h1>
                <p class='subtitle'>Améliorez votre expérience de jeu</p>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class='main-content'>
            <!-- Section Monnaie du joueur -->
            <section class='wallet-section'>
                <div class='wallet-card'>
                    <div class='wallet-icon'>💰</div>
                    <div class='wallet-info'>
                        <div class='wallet-label'>Votre solde</div>
                        <div class='wallet-amount'>1000 pièces</div>
                    </div>
                </div>
            </section>

            <!-- Section Packs de cartes -->
            <section class='shop-section'>
                <h2 class='section-title'>🎴 Packs de Cartes</h2>
                <div class='products-grid'>
                    <!-- Pack Débutant -->
                    <div class='product-card'>
                        <div class='product-badge product-badge-common'>BASIQUE</div>
                        <div class='product-icon'>📦</div>
                        <h3 class='product-name'>Pack Débutant</h3>
                        <p class='product-description'>5 cartes communes pour débuter votre collection</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>50</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-common'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Pack Standard -->
                    <div class='product-card'>
                        <div class='product-badge product-badge-rare'>RARE</div>
                        <div class='product-icon'>🎁</div>
                        <h3 class='product-name'>Pack Standard</h3>
                        <p class='product-description'>10 cartes dont 2 rares garanties</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>150</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-rare'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Pack Premium -->
                    <div class='product-card product-card-featured'>
                        <div class='product-badge product-badge-epic'>ÉPIQUE</div>
                        <div class='product-icon'>💎</div>
                        <h3 class='product-name'>Pack Premium</h3>
                        <p class='product-description'>15 cartes dont 5 rares et 1 épique garantie</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>300</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-epic'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Pack Légendaire -->
                    <div class='product-card product-card-legendary'>
                        <div class='product-badge product-badge-legendary'>LÉGENDAIRE</div>
                        <div class='product-icon'>👑</div>
                        <h3 class='product-name'>Pack Légendaire</h3>
                        <p class='product-description'>20 cartes dont 1 carte légendaire garantie</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>500</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-legendary'>ACHETER</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Cosmétiques -->
            <section class='shop-section'>
                <h2 class='section-title'>✨ Cosmétiques</h2>
                <div class='products-grid'>
                    <!-- Dos de carte -->
                    <div class='product-card'>
                        <div class='product-badge product-badge-rare'>RARE</div>
                        <div class='product-icon'>🃏</div>
                        <h3 class='product-name'>Dos de Carte Royal</h3>
                        <p class='product-description'>Un magnifique dos de carte aux motifs royaux</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>200</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-rare'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Tapis de jeu -->
                    <div class='product-card'>
                        <div class='product-badge product-badge-epic'>ÉPIQUE</div>
                        <div class='product-icon'>🎨</div>
                        <h3 class='product-name'>Tapis Émeraude</h3>
                        <p class='product-description'>Changez l'apparence de votre tapis de jeu</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>250</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-epic'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Avatar -->
                    <div class='product-card'>
                        <div class='product-badge product-badge-epic'>ÉPIQUE</div>
                        <div class='product-icon'>👤</div>
                        <h3 class='product-name'>Avatar Champion</h3>
                        <p class='product-description'>Un avatar exclusif pour les vrais champions</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>300</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-epic'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Effet spécial -->
                    <div class='product-card product-card-legendary'>
                        <div class='product-badge product-badge-legendary'>LÉGENDAIRE</div>
                        <div class='product-icon'>✨</div>
                        <h3 class='product-name'>Effet Victoire Doré</h3>
                        <p class='product-description'>Animation spéciale lors de vos victoires</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-amount'>400</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-legendary'>ACHETER</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Offres spéciales -->
            <section class='shop-section'>
                <h2 class='section-title'>🔥 Offres Spéciales</h2>
                <div class='products-grid'>
                    <!-- Pack starter -->
                    <div class='product-card product-card-special'>
                        <div class='product-badge product-badge-special'>PROMO</div>
                        <div class='product-icon'>🎉</div>
                        <h3 class='product-name'>Pack Starter Complet</h3>
                        <p class='product-description'>Tout ce dont vous avez besoin pour bien démarrer</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-old'>800</span>
                                <span class='price-amount'>600</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-special'>ACHETER</button>
                        </div>
                    </div>

                    <!-- Pack ultime -->
                    <div class='product-card product-card-special'>
                        <div class='product-badge product-badge-special'>PROMO</div>
                        <div class='product-icon'>🌟</div>
                        <h3 class='product-name'>Pack Ultime</h3>
                        <p class='product-description'>Tous les cosmétiques + 50 cartes premium</p>
                        <div class='product-footer'>
                            <div class='product-price'>
                                <span class='price-old'>1500</span>
                                <span class='price-amount'>1200</span>
                                <span class='price-currency'>pièces</span>
                            </div>
                            <button class='btn-buy btn-buy-special'>ACHETER</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section d'action -->
            <section class='action-section'>
                <div class='action-card'>
                    <p class='action-text'>Gagnez des pièces en jouant et en remportant des parties !</p>
                    <div class='action-buttons'>
                        <a href='duel.php' class='btn-action btn-primary'>
                            <span class='btn-text'>JOUER MAINTENANT</span>
                            <span class='btn-icon'>⚔️</span>
                        </a>
                        <a href='index.php' class='btn-action btn-secondary'>
                            <span class='btn-text'>RETOUR ACCUEIL</span>
                            <span class='btn-icon'>🏠</span>
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class='footer'>
            <p class='footer-text'>© 2025 Ludos - Jeu de cartes</p>
        </footer>
    </div>
</body>
</html>

