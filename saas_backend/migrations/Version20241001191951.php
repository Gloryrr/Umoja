<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001191951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT NOT NULL, email_utilisateur VARCHAR(128) NOT NULL, mdp_utilisateur VARCHAR(255) NOT NULL, role_utilisateur VARCHAR(20) NOT NULL, username VARCHAR(50) NOT NULL, num_tel_utilisateur VARCHAR(15) DEFAULT NULL, nom_utilisateur VARCHAR(50) DEFAULT NULL, prenom_utilisateur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id_utilisateur))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE utilisateur');
    }
}
