<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241115213553 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE preference_notification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE preference_notification (id INT NOT NULL, email_nouvelle_offre BOOLEAN NOT NULL, email_update_offre BOOLEAN NOT NULL, reponse_offre BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE utilisateur ADD preference_notification_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B39D5D70F2 FOREIGN KEY (preference_notification_id) REFERENCES preference_notification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1D1C63B39D5D70F2 ON utilisateur (preference_notification_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B39D5D70F2');
        $this->addSql('DROP SEQUENCE preference_notification_id_seq CASCADE');
        $this->addSql('DROP TABLE preference_notification');
        $this->addSql('DROP INDEX IDX_1D1C63B39D5D70F2');
        $this->addSql('ALTER TABLE utilisateur DROP preference_notification_id');
    }
}
