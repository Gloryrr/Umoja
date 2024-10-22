<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241022152107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appartenir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE artiste_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE attacher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE budget_estimatif_id_be_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commentaire_id_commentaire_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE concerner_id_c_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE conditions_financieres_id_cf_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE creer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_offre_id_etat_offre_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etat_reponse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE extras_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fiche_technique_artiste_id_ft_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE genre_musical_id_genre_musical_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE poster_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE preferencer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rattacher_id_a_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reponse_id_r_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reseau_id_reseau_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_offre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_utilisateur_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appartenir (id INT NOT NULL, id_reseau_id INT NOT NULL, id_utilisateur_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2A0D90CC468AB2B ON appartenir (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_A2A0D90CC6EE5C49 ON appartenir (id_utilisateur_id)');
        $this->addSql('CREATE TABLE artiste (id INT NOT NULL, nom_artiste VARCHAR(50) NOT NULL, descr_artiste VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE attacher (id INT NOT NULL, id_artiste_id INT NOT NULL, genres_attaches_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9C73D7D98458D893 ON attacher (id_artiste_id)');
        $this->addSql('CREATE INDEX IDX_9C73D7D92054FC5D ON attacher (genres_attaches_id)');
        $this->addSql('CREATE TABLE budget_estimatif (id_be INT NOT NULL, cachet_artiste INT NOT NULL, frais_deplacement INT NOT NULL, frais_hebergement INT NOT NULL, frais_restauration INT NOT NULL, PRIMARY KEY(id_be))');
        $this->addSql('CREATE TABLE commentaire (id_commentaire INT NOT NULL, id_utilisateur_id INT NOT NULL, id_offre_id INT NOT NULL, commentaire VARCHAR(500) NOT NULL, PRIMARY KEY(id_commentaire))');
        $this->addSql('CREATE INDEX IDX_67F068BCC6EE5C49 ON commentaire (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC1C13BCCF ON commentaire (id_offre_id)');
        $this->addSql('CREATE TABLE concerner (id_c INT NOT NULL, id_artiste_id INT NOT NULL, id_offre_id INT NOT NULL, PRIMARY KEY(id_c))');
        $this->addSql('CREATE INDEX IDX_ABE9A8668458D893 ON concerner (id_artiste_id)');
        $this->addSql('CREATE INDEX IDX_ABE9A8661C13BCCF ON concerner (id_offre_id)');
        $this->addSql('CREATE TABLE conditions_financieres (id_cf INT NOT NULL, minimun_garanti INT NOT NULL, conditions_paiement TEXT NOT NULL, pourcentage_recette DOUBLE PRECISION NOT NULL, PRIMARY KEY(id_cf))');
        $this->addSql('CREATE TABLE creer (id INT NOT NULL, id_utilisateur_id INT NOT NULL, id_offre_id INT NOT NULL, contact VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_311B14AEC6EE5C49 ON creer (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_311B14AE1C13BCCF ON creer (id_offre_id)');
        $this->addSql('CREATE TABLE etat_offre (id_etat_offre INT NOT NULL, nom_etat VARCHAR(50) NOT NULL, PRIMARY KEY(id_etat_offre))');
        $this->addSql('CREATE TABLE etat_reponse (id INT NOT NULL, nom_etat_reponse VARCHAR(100) NOT NULL, description_etat_reponse VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE extras (id INT NOT NULL, descr_extras VARCHAR(255) DEFAULT NULL, cout_extras INT DEFAULT NULL, exclusivite VARCHAR(255) DEFAULT NULL, exception VARCHAR(255) DEFAULT NULL, ordre_passage VARCHAR(255) DEFAULT NULL, clauses_confidentialites VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE fiche_technique_artiste (id_ft INT NOT NULL, besoin_sonorisation TEXT DEFAULT NULL, besoin_eclairage TEXT DEFAULT NULL, besoin_scene TEXT DEFAULT NULL, besoin_backline TEXT DEFAULT NULL, besoin_equipements TEXT DEFAULT NULL, PRIMARY KEY(id_ft))');
        $this->addSql('CREATE TABLE genre_musical (id_genre_musical INT NOT NULL, nom_genre_musical VARCHAR(50) NOT NULL, PRIMARY KEY(id_genre_musical))');
        $this->addSql('CREATE TABLE lier (id INT NOT NULL, id_reseau_id INT NOT NULL, id_genre_musical_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B133E8FAC468AB2B ON lier (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_B133E8FA1C77500D ON lier (id_genre_musical_id)');
        $this->addSql('CREATE TABLE offre (id INT NOT NULL, extras_id INT NOT NULL, etat_offre_id INT NOT NULL, type_offre_id INT NOT NULL, conditions_financieres_id INT NOT NULL, budget_estimatif_id INT NOT NULL, fiche_technique_artiste_id INT NOT NULL, title_offre VARCHAR(50) NOT NULL, dead_line TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, descr_tournee VARCHAR(500) NOT NULL, date_min_proposee TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_max_proposee TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ville_visee VARCHAR(50) NOT NULL, region_visee VARCHAR(50) NOT NULL, places_min INT NOT NULL, places_max INT NOT NULL, nb_artistes_concernes INT NOT NULL, nb_invites_concernes INT NOT NULL, liens_promotionnels VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AF86866F955D4F3F ON offre (extras_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FD11DF8CA ON offre (etat_offre_id)');
        $this->addSql('CREATE INDEX IDX_AF86866F813777A6 ON offre (type_offre_id)');
        $this->addSql('CREATE INDEX IDX_AF86866F1C2126BA ON offre (conditions_financieres_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FBDD7A196 ON offre (budget_estimatif_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FC3E139A ON offre (fiche_technique_artiste_id)');
        $this->addSql('CREATE TABLE poster (id INT NOT NULL, id_reseau_id INT NOT NULL, id_offre_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D710CF2C468AB2B ON poster (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_2D710CF21C13BCCF ON poster (id_offre_id)');
        $this->addSql('CREATE TABLE preferencer (id INT NOT NULL, id_utilisateur_id INT NOT NULL, id_genre_musical_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9E369663C6EE5C49 ON preferencer (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_9E3696631C77500D ON preferencer (id_genre_musical_id)');
        $this->addSql('CREATE TABLE rattacher (id_a INT NOT NULL, id_offre_id INT NOT NULL, id_genre_musical_id INT NOT NULL, PRIMARY KEY(id_a))');
        $this->addSql('CREATE INDEX IDX_C10DF74D1C13BCCF ON rattacher (id_offre_id)');
        $this->addSql('CREATE INDEX IDX_C10DF74D1C77500D ON rattacher (id_genre_musical_id)');
        $this->addSql('CREATE TABLE reponse (id_r INT NOT NULL, id_etat_reponse_id INT NOT NULL, id_offre_id INT NOT NULL, date_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, prix_participation DOUBLE PRECISION NOT NULL, PRIMARY KEY(id_r))');
        $this->addSql('CREATE INDEX IDX_5FB6DEC78F0A441F ON reponse (id_etat_reponse_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC71C13BCCF ON reponse (id_offre_id)');
        $this->addSql('CREATE TABLE reseau (id_reseau INT NOT NULL, nom_reseau VARCHAR(100) NOT NULL, PRIMARY KEY(id_reseau))');
        $this->addSql('CREATE TABLE type_offre (id INT NOT NULL, nom_type_offre VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT NOT NULL, email_utilisateur VARCHAR(128) NOT NULL, mdp_utilisateur VARCHAR(255) NOT NULL, role_utilisateur VARCHAR(20) NOT NULL, username VARCHAR(50) NOT NULL, num_tel_utilisateur VARCHAR(15) DEFAULT NULL, nom_utilisateur VARCHAR(50) DEFAULT NULL, prenom_utilisateur VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id_utilisateur))');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CC468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attacher ADD CONSTRAINT FK_9C73D7D98458D893 FOREIGN KEY (id_artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE attacher ADD CONSTRAINT FK_9C73D7D92054FC5D FOREIGN KEY (genres_attaches_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC1C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE concerner ADD CONSTRAINT FK_ABE9A8668458D893 FOREIGN KEY (id_artiste_id) REFERENCES artiste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE concerner ADD CONSTRAINT FK_ABE9A8661C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creer ADD CONSTRAINT FK_311B14AEC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creer ADD CONSTRAINT FK_311B14AE1C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAC468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA1C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F955D4F3F FOREIGN KEY (extras_id) REFERENCES extras (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FD11DF8CA FOREIGN KEY (etat_offre_id) REFERENCES etat_offre (id_etat_offre) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F813777A6 FOREIGN KEY (type_offre_id) REFERENCES type_offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F1C2126BA FOREIGN KEY (conditions_financieres_id) REFERENCES conditions_financieres (id_cf) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBDD7A196 FOREIGN KEY (budget_estimatif_id) REFERENCES budget_estimatif (id_be) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FC3E139A FOREIGN KEY (fiche_technique_artiste_id) REFERENCES fiche_technique_artiste (id_ft) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF2C468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poster ADD CONSTRAINT FK_2D710CF21C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E369663C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E3696631C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rattacher ADD CONSTRAINT FK_C10DF74D1C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rattacher ADD CONSTRAINT FK_C10DF74D1C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC78F0A441F FOREIGN KEY (id_etat_reponse_id) REFERENCES etat_reponse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE appartenir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE artiste_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE attacher_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE budget_estimatif_id_be_seq CASCADE');
        $this->addSql('DROP SEQUENCE commentaire_id_commentaire_seq CASCADE');
        $this->addSql('DROP SEQUENCE concerner_id_c_seq CASCADE');
        $this->addSql('DROP SEQUENCE conditions_financieres_id_cf_seq CASCADE');
        $this->addSql('DROP SEQUENCE creer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_offre_id_etat_offre_seq CASCADE');
        $this->addSql('DROP SEQUENCE etat_reponse_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE extras_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fiche_technique_artiste_id_ft_seq CASCADE');
        $this->addSql('DROP SEQUENCE genre_musical_id_genre_musical_seq CASCADE');
        $this->addSql('DROP SEQUENCE lier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE poster_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE preferencer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rattacher_id_a_seq CASCADE');
        $this->addSql('DROP SEQUENCE reponse_id_r_seq CASCADE');
        $this->addSql('DROP SEQUENCE reseau_id_reseau_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_offre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_utilisateur_seq CASCADE');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CC468AB2B');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CC6EE5C49');
        $this->addSql('ALTER TABLE attacher DROP CONSTRAINT FK_9C73D7D98458D893');
        $this->addSql('ALTER TABLE attacher DROP CONSTRAINT FK_9C73D7D92054FC5D');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCC6EE5C49');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BC1C13BCCF');
        $this->addSql('ALTER TABLE concerner DROP CONSTRAINT FK_ABE9A8668458D893');
        $this->addSql('ALTER TABLE concerner DROP CONSTRAINT FK_ABE9A8661C13BCCF');
        $this->addSql('ALTER TABLE creer DROP CONSTRAINT FK_311B14AEC6EE5C49');
        $this->addSql('ALTER TABLE creer DROP CONSTRAINT FK_311B14AE1C13BCCF');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FAC468AB2B');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FA1C77500D');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866F955D4F3F');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FD11DF8CA');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866F813777A6');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866F1C2126BA');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FBDD7A196');
        $this->addSql('ALTER TABLE offre DROP CONSTRAINT FK_AF86866FC3E139A');
        $this->addSql('ALTER TABLE poster DROP CONSTRAINT FK_2D710CF2C468AB2B');
        $this->addSql('ALTER TABLE poster DROP CONSTRAINT FK_2D710CF21C13BCCF');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E369663C6EE5C49');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E3696631C77500D');
        $this->addSql('ALTER TABLE rattacher DROP CONSTRAINT FK_C10DF74D1C13BCCF');
        $this->addSql('ALTER TABLE rattacher DROP CONSTRAINT FK_C10DF74D1C77500D');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC78F0A441F');
        $this->addSql('ALTER TABLE reponse DROP CONSTRAINT FK_5FB6DEC71C13BCCF');
        $this->addSql('DROP TABLE appartenir');
        $this->addSql('DROP TABLE artiste');
        $this->addSql('DROP TABLE attacher');
        $this->addSql('DROP TABLE budget_estimatif');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE concerner');
        $this->addSql('DROP TABLE conditions_financieres');
        $this->addSql('DROP TABLE creer');
        $this->addSql('DROP TABLE etat_offre');
        $this->addSql('DROP TABLE etat_reponse');
        $this->addSql('DROP TABLE extras');
        $this->addSql('DROP TABLE fiche_technique_artiste');
        $this->addSql('DROP TABLE genre_musical');
        $this->addSql('DROP TABLE lier');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE poster');
        $this->addSql('DROP TABLE preferencer');
        $this->addSql('DROP TABLE rattacher');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE reseau');
        $this->addSql('DROP TABLE type_offre');
        $this->addSql('DROP TABLE utilisateur');
    }
}
