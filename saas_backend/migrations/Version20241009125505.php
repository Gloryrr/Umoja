<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009125505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appartenir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE budget_estimatif_id_be_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commentaire_id_commentaire_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE conditions_financieres_id_cf_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_offre_id_etat_offre_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_musical_id_genre_musical_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE preferencer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reseau_id_reseau_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appartenir (id INT NOT NULL, id_reseau_id INT NOT NULL, id_utilisateur_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2A0D90CC468AB2B ON appartenir (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_A2A0D90CC6EE5C49 ON appartenir (id_utilisateur_id)');
        $this->addSql('CREATE TABLE budget_estimatif (id_be INT NOT NULL, cachet_artiste INT NOT NULL, frais_deplacement INT NOT NULL, frais_hebergement INT NOT NULL, frais_restauration INT NOT NULL, PRIMARY KEY(id_be))');
        $this->addSql('CREATE TABLE commentaire (id_commentaire INT NOT NULL, id_utilisateur_id INT NOT NULL, commentaire VARCHAR(500) NOT NULL, PRIMARY KEY(id_commentaire))');
        $this->addSql('CREATE INDEX IDX_67F068BCC6EE5C49 ON commentaire (id_utilisateur_id)');
        $this->addSql('CREATE TABLE conditions_financieres (id_cf INT NOT NULL, minimun_garanti INT NOT NULL, conditions_paiement TEXT NOT NULL, pourcentage_recette DOUBLE PRECISION NOT NULL, PRIMARY KEY(id_cf))');
        $this->addSql('CREATE TABLE etat_offre (id_etat_offre INT NOT NULL, nom_etat VARCHAR(50) NOT NULL, PRIMARY KEY(id_etat_offre))');
        $this->addSql('CREATE TABLE genre_musical (id_genre_musical INT NOT NULL, nom_genre_musical VARCHAR(50) NOT NULL, PRIMARY KEY(id_genre_musical))');
        $this->addSql('CREATE TABLE lier (id INT NOT NULL, id_reseau_id INT NOT NULL, id_genre_musical_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B133E8FAC468AB2B ON lier (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_B133E8FA1C77500D ON lier (id_genre_musical_id)');
        $this->addSql('CREATE TABLE preferencer (id INT NOT NULL, id_utilisateur_id INT NOT NULL, id_genre_musical_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9E369663C6EE5C49 ON preferencer (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_9E3696631C77500D ON preferencer (id_genre_musical_id)');
        $this->addSql('CREATE TABLE reseau (id_reseau INT NOT NULL, nom_reseau VARCHAR(100) NOT NULL, PRIMARY KEY(id_reseau))');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CC468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAC468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA1C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E369663C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E3696631C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE appartenir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE budget_estimatif_id_be_seq CASCADE');
        $this->addSql('DROP SEQUENCE commentaire_id_commentaire_seq CASCADE');
        $this->addSql('DROP SEQUENCE conditions_financieres_id_cf_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_offre_id_etat_offre_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_musical_id_genre_musical_seq CASCADE');
        $this->addSql('DROP SEQUENCE lier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE preferencer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reseau_id_reseau_seq CASCADE');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CC468AB2B');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CC6EE5C49');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCC6EE5C49');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FAC468AB2B');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FA1C77500D');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E369663C6EE5C49');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E3696631C77500D');
        $this->addSql('DROP TABLE appartenir');
        $this->addSql('DROP TABLE budget_estimatif');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE conditions_financieres');
        $this->addSql('DROP TABLE etat_offre');
        $this->addSql('DROP TABLE genre_musical');
        $this->addSql('DROP TABLE lier');
        $this->addSql('DROP TABLE preferencer');
        $this->addSql('DROP TABLE reseau');
    }
}
