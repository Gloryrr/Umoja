<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007202942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE preferencer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE preferencer (id INT NOT NULL, id_utilisateur_id INT NOT NULL, id_genre_musical_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9E369663C6EE5C49 ON preferencer (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_9E3696631C77500D ON preferencer (id_genre_musical_id)');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E369663C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE preferencer ADD CONSTRAINT FK_9E3696631C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE preferencer_id_seq CASCADE');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E369663C6EE5C49');
        $this->addSql('ALTER TABLE preferencer DROP CONSTRAINT FK_9E3696631C77500D');
        $this->addSql('DROP TABLE preferencer');
    }
}
