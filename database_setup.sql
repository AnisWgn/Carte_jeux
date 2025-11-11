-- Script SQL pour créer la base de données Ludos
-- À exécuter dans phpMyAdmin ou via la ligne de commande MySQL

-- 1. Créer la base de données
CREATE DATABASE IF NOT EXISTS ludos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Utiliser la base de données
USE ludos_db;

-- 3. Créer la table users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT NOT NULL,
    username VARCHAR(180) NOT NULL,
    email VARCHAR(255) NOT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL,
    coins INT DEFAULT 1000 NOT NULL,
    total_games INT DEFAULT 0 NOT NULL,
    total_wins INT DEFAULT 0 NOT NULL,
    total_score INT DEFAULT 0 NOT NULL,
    created_at DATETIME NOT NULL,
    UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username),
    UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email),
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Afficher la structure de la table
DESCRIBE users;

-- Note: Les migrations Doctrine peuvent aussi être utilisées avec la commande:
-- php bin/console doctrine:migrations:migrate

