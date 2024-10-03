<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241003205943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lier (id_reseau INT NOT NULL, id_genre_musical INT NOT NULL, PRIMARY KEY(id_reseau, id_genre_musical))');
        $this->addSql('CREATE INDEX IDX_B133E8FAEBD29955 ON lier (id_reseau)');
        $this->addSql('CREATE INDEX IDX_B133E8FA23600CCE ON lier (id_genre_musical)');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAEBD29955 FOREIGN KEY (id_reseau) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA23600CCE FOREIGN KEY (id_genre_musical) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FAEBD29955');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FA23600CCE');
        $this->addSql('DROP TABLE lier');
    }
}
