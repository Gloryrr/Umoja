<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007172938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appartenir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_offre_id_etat_offre_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_musical_id_genre_musical_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reseau_id_reseau_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_utilisateur_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appartenir (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etat_offre (id_etat_offre INT NOT NULL, nom_etat VARCHAR(50) NOT NULL, PRIMARY KEY(id_etat_offre))');
        $this->addSql('CREATE TABLE genre_musical (id_genre_musical INT NOT NULL, nom_genre_musical VARCHAR(50) NOT NULL, PRIMARY KEY(id_genre_musical))');
        $this->addSql('CREATE TABLE lier (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE reseau (id_reseau INT NOT NULL, nom_reseau VARCHAR(100) NOT NULL, PRIMARY KEY(id_reseau))');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT NOT NULL, email_utilisateur VARCHAR(128) NOT NULL, mdp_utilisateur VARCHAR(255) NOT NULL, role_utilisateur VARCHAR(20) NOT NULL, username VARCHAR(50) NOT NULL, num_tel_utilisateur VARCHAR(15) DEFAULT NULL, nom_utilisateur VARCHAR(50) DEFAULT NULL, prenom_utilisateur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id_utilisateur))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE appartenir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_offre_id_etat_offre_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_musical_id_genre_musical_seq CASCADE');
        $this->addSql('DROP SEQUENCE lier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reseau_id_reseau_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_utilisateur_seq CASCADE');
        $this->addSql('DROP TABLE appartenir');
        $this->addSql('DROP TABLE etat_offre');
        $this->addSql('DROP TABLE genre_musical');
        $this->addSql('DROP TABLE lier');
        $this->addSql('DROP TABLE reseau');
        $this->addSql('DROP TABLE utilisateur');
    }
}
