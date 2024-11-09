<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241109210430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE artiste_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE budget_estimatif_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commentaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE conditions_financieres_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_reponse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE extras_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fiche_technique_artiste_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_musical_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reponse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reseau_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE artiste (id INT NOT NULL, nom_artiste VARCHAR(50) NOT NULL, descr_artiste VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE attacher (artiste_id INT NOT NULL, genre_musical_id INT NOT NULL, PRIMARY KEY(artiste_id, genre_musical_id))');
        $this->addSql('CREATE INDEX IDX_9C73D7D921D25844 ON attacher (artiste_id)');
        $this->addSql('CREATE INDEX IDX_9C73D7D9FFFD05DC ON attacher (genre_musical_id)');
        $this->addSql('CREATE TABLE concerner (artiste_id INT NOT NULL, offre_id INT NOT NULL, PRIMARY KEY(artiste_id, offre_id))');
        $this->addSql('CREATE INDEX IDX_ABE9A86621D25844 ON concerner (artiste_id)');
        $this->addSql('CREATE INDEX IDX_ABE9A8664CC8505A ON concerner (offre_id)');
        $this->addSql('CREATE TABLE budget_estimatif (id INT NOT NULL, cachet_artiste INT NOT NULL, frais_deplacement INT NOT NULL, frais_hebergement INT NOT NULL, frais_restauration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE commentaire (id INT NOT NULL, utilisateur_id INT NOT NULL, offre_id INT NOT NULL, commentaire VARCHAR(500) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_67F068BCFB88E14F ON commentaire (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC4CC8505A ON commentaire (offre_id)');
        $this->addSql('CREATE TABLE conditions_financieres (id INT NOT NULL, minimun_garanti INT NOT NULL, conditions_paiement TEXT NOT NULL, pourcentage_recette DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etat_offre (id INT NOT NULL, nom_etat VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE etat_reponse (id INT NOT NULL, nom_etat_reponse VARCHAR(100) NOT NULL, description_etat_reponse VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE extras (id INT NOT NULL, descr_extras VARCHAR(255) DEFAULT NULL, cout_extras INT DEFAULT NULL, exclusivite VARCHAR(255) DEFAULT NULL, exception VARCHAR(255) DEFAULT NULL, ordre_passage VARCHAR(255) DEFAULT NULL, clauses_confidentialites VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE fiche_technique_artiste (id INT NOT NULL, besoin_sonorisation TEXT DEFAULT NULL, besoin_eclairage TEXT DEFAULT NULL, besoin_scene TEXT DEFAULT NULL, besoin_backline TEXT DEFAULT NULL, besoin_equipements TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre_musical (id INT NOT NULL, nom_genre_musical VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rattacher (genre_musical_id INT NOT NULL, offre_id INT NOT NULL, PRIMARY KEY(genre_musical_id, offre_id))');
        $this->addSql('CREATE INDEX IDX_C10DF74DFFFD05DC ON rattacher (genre_musical_id)');
        $this->addSql('CREATE INDEX IDX_C10DF74D4CC8505A ON rattacher (offre_id)');
        $this->addSql('CREATE TABLE offre (id INT NOT NULL, extras_id INT NOT NULL, etat_offre_id INT NOT NULL, type_offre_id INT NOT NULL, conditions_financieres_id INT NOT NULL, budget_estimatif_id INT NOT NULL, fiche_technique_artiste_id INT NOT NULL, utilisateur_id INT NOT NULL, title_offre VARCHAR(50) NOT NULL, dead_line TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, descr_tournee VARCHAR(500) NOT NULL, date_min_proposee TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_max_proposee TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ville_visee VARCHAR(50) NOT NULL, region_visee VARCHAR(50) NOT NULL, places_min INT NOT NULL, places_max INT NOT NULL, nb_artistes_concernes INT NOT NULL, nb_invites_concernes INT NOT NULL, liens_promotionnels VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AF86866F955D4F3F ON offre (extras_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FD11DF8CA ON offre (etat_offre_id)');
        $this->addSql('CREATE INDEX IDX_AF86866F813777A6 ON offre (type_offre_id)');
        $this->addSql('CREATE INDEX IDX_AF86866F1C2126BA ON offre (conditions_financieres_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FBDD7A196 ON offre (budget_estimatif_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FC3E139A ON offre (fiche_technique_artiste_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FFB88E14F ON offre (utilisateur_id)');
        $this->addSql('CREATE TABLE reponse (id INT NOT NULL, etat_reponse_id INT NOT NULL, offre_id INT NOT NULL, utilisateur_id INT NOT NULL, date_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, prix_participation DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5FB6DEC766548797 ON reponse (etat_reponse_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC74CC8505A ON reponse (offre_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7FB88E14F ON reponse (utilisateur_id)');
        $this->addSql('CREATE TABLE reseau (id INT NOT NULL, nom_reseau VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lier (reseau_id INT NOT NULL, genre_musical_id INT NOT NULL, PRIMARY KEY(reseau_id, genre_musical_id))');
        $this->addSql('CREATE INDEX IDX_B133E8FA445D170C ON lier (reseau_id)');
        $this->addSql('CREATE INDEX IDX_B133E8FAFFFD05DC ON lier (genre_musical_id)');
        $this->addSql('CREATE TABLE poster (reseau_id INT NOT NULL, offre_id INT NOT NULL, PRIMARY KEY(reseau_id, offre_id))');
        $this->addSql('CREATE INDEX IDX_2D710CF2445D170C ON poster (reseau_id)');
        $this->addSql('CREATE INDEX IDX_2D710CF24CC8505A ON poster (offre_id)');
        $this->addSql('CREATE TABLE type_offre (id INT NOT NULL, nom_type_offre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, email_utilisateur VARCHAR(128) NOT NULL, mdp_utilisateur VARCHAR(255) NOT NULL, role_utilisateur VARCHAR(20) NOT NULL, username VARCHAR(50) NOT NULL, num_tel_utilisateur VARCHAR(15) DEFAULT NULL, nom_utilisateur VARCHAR(50) DEFAULT NULL, prenom_utilisateur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE preferencer (utilisateur_id INT NOT NULL, genre_musical_id INT NOT NULL, PRIMARY KEY(utilisateur_id, genre_musical_id))');
        $this->addSql('CREATE INDEX IDX_9E369663FB88E14F ON preferencer (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_9E369663FFFD05DC ON preferencer (genre_musical_id)');
        $this->addSql('CREATE TABLE appartenir (utilisateur_id INT NOT NULL, reseau_id INT NOT NULL, PRIMARY KEY(utilisateur_id, reseau_id))');
        $this->addSql('CREATE INDEX IDX_A2A0D90CFB88E14F ON appartenir (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_A2A0D90C445D170C ON appartenir (reseau_id)');
        $this->addSql('ALTER TABLE attacher ADD CONSTRAINT FK_9C73D7D921D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attacher ADD CONSTRAINT FK_9C73D7D9FFFD05DC FOREIGN KEY (genre_musical_id) REFERENCES genre_musical (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE concerner ADD CONSTRAINT FK_ABE9A86621D25844 FOREIGN KEY (artiste_id) REFERENCES artiste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE concerner ADD CONSTRAINT FK_ABE9A8664CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rattacher ADD CONSTRAINT FK_C10DF74DFFFD05DC FOREIGN KEY (genre_musical_id) REFERENCES genre_musical (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rattacher ADD CONSTRAINT FK_C10DF74D4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F955D4F3F FOREIGN KEY (extras_id) REFERENCES extras (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FD11DF8CA FOREIGN KEY (etat_offre_id) REFERENCES etat_offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F813777A6 FOREIGN KEY (type_offre_id) REFERENCES type_offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F1C2126BA FOREIGN KEY (conditions_financieres_id) REFERENCES conditions_financieres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBDD7A196 FOREIGN KEY (budget_estimatif_id) REFERENCES budget_estimatif (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FC3E139A FOREIGN KEY (fiche_technique_artiste_id) REFERENCES fiche_technique_artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC766548797 FOREIGN KEY (etat_reponse_id) REFERENCES etat_reponse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC74CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA445D170C FOREIGN KEY (reseau_id) REFERENCES reseau (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAFFFD05DC FOREIGN KEY (genre_musical_id) REFERENCES genre_musical (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF2445D170C FOREIGN KEY (reseau_id) REFERENCES reseau (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF24CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E369663FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E369663FFFD05DC FOREIGN KEY (genre_musical_id) REFERENCES genre_musical (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90C445D170C FOREIGN KEY (reseau_id) REFERENCES reseau (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE artiste_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE budget_estimatif_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commentaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE conditions_financieres_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_offre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_reponse_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE extras_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fiche_technique_artiste_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_musical_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reponse_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reseau_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_offre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('ALTER TABLE attacher DROP CONSTRAINT FK_9C73D7D921D25844');
        $this->addSql('ALTER TABLE attacher DROP CONSTRAINT FK_9C73D7D9FFFD05DC');
        $this->addSql('ALTER TABLE concerner DROP CONSTRAINT FK_ABE9A86621D25844');
        $this->addSql('ALTER TABLE concerner DROP CONSTRAINT FK_ABE9A8664CC8505A');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BC4CC8505A');
        $this->addSql('ALTER TABLE rattacher DROP CONSTRAINT FK_C10DF74DFFFD05DC');
        $this->addSql('ALTER TABLE rattacher DROP CONSTRAINT FK_C10DF74D4CC8505A');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866F955D4F3F');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FD11DF8CA');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866F813777A6');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866F1C2126BA');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FBDD7A196');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FC3E139A');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FFB88E14F');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC766548797');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC74CC8505A');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC7FB88E14F');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FA445D170C');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FAFFFD05DC');
        $this->addSql('ALTER TABLE poster DROP CONSTRAINT FK_2D710CF2445D170C');
        $this->addSql('ALTER TABLE poster DROP CONSTRAINT FK_2D710CF24CC8505A');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E369663FB88E14F');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E369663FFFD05DC');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CFB88E14F');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90C445D170C');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE attacher');
        $this->addSql('DROP TABLE concerner');
        $this->addSql('DROP TABLE budget_estimatif');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE conditions_financieres');
        $this->addSql('DROP TABLE etat_offre');
        $this->addSql('DROP TABLE etat_reponse');
        $this->addSql('DROP TABLE extras');
        $this->addSql('DROP TABLE fiche_technique_artiste');
        $this->addSql('DROP TABLE genre_musical');
        $this->addSql('DROP TABLE rattacher');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reseau');
        $this->addSql('DROP TABLE lier');
        $this->addSql('DROP TABLE poster');
        $this->addSql('DROP TABLE type_offre');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE preferencer');
        $this->addSql('DROP TABLE appartenir');
    }
}
