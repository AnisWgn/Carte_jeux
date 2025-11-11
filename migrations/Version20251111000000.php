<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration pour créer la table users
 */
final class Version20251111000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table users pour l\'authentification';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users (
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
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users');
    }
}

