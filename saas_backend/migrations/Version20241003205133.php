<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003205133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE reseau_id_reseau_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reseau (id_reseau INT NOT NULL, nom_reseau VARCHAR(100) NOT NULL, PRIMARY KEY(id_reseau))');
        $this->addSql('CREATE TABLE appartient (id_reseau INT NOT NULL, id_utilisateur INT NOT NULL, PRIMARY KEY(id_reseau, id_utilisateur))');
        $this->addSql('CREATE INDEX IDX_4201BAA7EBD29955 ON appartient (id_reseau)');
        $this->addSql('CREATE INDEX IDX_4201BAA750EAE44 ON appartient (id_utilisateur)');
        $this->addSql('ALTER TABLE appartient ADD CONSTRAINT FK_4201BAA7EBD29955 FOREIGN KEY (id_reseau) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartient ADD CONSTRAINT FK_4201BAA750EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE reseau_id_reseau_seq CASCADE');
        $this->addSql('ALTER TABLE appartient DROP CONSTRAINT FK_4201BAA7EBD29955');
        $this->addSql('ALTER TABLE appartient DROP CONSTRAINT FK_4201BAA750EAE44');
        $this->addSql('DROP TABLE reseau');
        $this->addSql('DROP TABLE appartient');
    }
}
