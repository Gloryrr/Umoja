<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007124129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE appartenir_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE appartenir (id INT NOT NULL, id_reseau INT NOT NULL, id_utilisateur INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2A0D90CEBD29955 ON appartenir (id_reseau)');
        $this->addSql('CREATE INDEX IDX_A2A0D90C50EAE44 ON appartenir (id_utilisateur)');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CEBD29955 FOREIGN KEY (id_reseau) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90C50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartient DROP CONSTRAINT fk_4201baa7ebd29955');
        $this->addSql('ALTER TABLE appartient DROP CONSTRAINT fk_4201baa750eae44');
        $this->addSql('DROP TABLE appartient');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT lier_pkey');
        $this->addSql('ALTER TABLE lier ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE lier ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE appartenir_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lier_id_seq CASCADE');
        $this->addSql('CREATE TABLE appartient (id_reseau INT NOT NULL, id_utilisateur INT NOT NULL, PRIMARY KEY(id_reseau, id_utilisateur))');
        $this->addSql('CREATE INDEX idx_4201baa750eae44 ON appartient (id_utilisateur)');
        $this->addSql('CREATE INDEX idx_4201baa7ebd29955 ON appartient (id_reseau)');
        $this->addSql('ALTER TABLE appartient ADD CONSTRAINT fk_4201baa7ebd29955 FOREIGN KEY (id_reseau) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartient ADD CONSTRAINT fk_4201baa750eae44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CEBD29955');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90C50EAE44');
        $this->addSql('DROP TABLE appartenir');
        $this->addSql('DROP INDEX lier_pkey');
        $this->addSql('ALTER TABLE lier DROP id');
        $this->addSql('ALTER TABLE lier ADD PRIMARY KEY (id_reseau, id_genre_musical)');
    }
}
