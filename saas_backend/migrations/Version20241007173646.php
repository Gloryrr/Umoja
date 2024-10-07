<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007173646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appartenir ADD id_reseau_id INT NOT NULL');
        $this->addSql('ALTER TABLE appartenir ADD id_utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CC468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE appartenir ADD CONSTRAINT FK_A2A0D90CC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id_utilisateur) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A2A0D90CC468AB2B ON appartenir (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_A2A0D90CC6EE5C49 ON appartenir (id_utilisateur_id)');
        $this->addSql('ALTER TABLE lier ADD id_reseau_id INT NOT NULL');
        $this->addSql('ALTER TABLE lier ADD id_genre_musical_id INT NOT NULL');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FAC468AB2B FOREIGN KEY (id_reseau_id) REFERENCES reseau (id_reseau) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lier ADD CONSTRAINT FK_B133E8FA1C77500D FOREIGN KEY (id_genre_musical_id) REFERENCES genre_musical (id_genre_musical) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B133E8FAC468AB2B ON lier (id_reseau_id)');
        $this->addSql('CREATE INDEX IDX_B133E8FA1C77500D ON lier (id_genre_musical_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CC468AB2B');
        $this->addSql('ALTER TABLE appartenir DROP CONSTRAINT FK_A2A0D90CC6EE5C49');
        $this->addSql('DROP INDEX IDX_A2A0D90CC468AB2B');
        $this->addSql('DROP INDEX IDX_A2A0D90CC6EE5C49');
        $this->addSql('ALTER TABLE appartenir DROP id_reseau_id');
        $this->addSql('ALTER TABLE appartenir DROP id_utilisateur_id');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FAC468AB2B');
        $this->addSql('ALTER TABLE lier DROP CONSTRAINT FK_B133E8FA1C77500D');
        $this->addSql('DROP INDEX IDX_B133E8FAC468AB2B');
        $this->addSql('DROP INDEX IDX_B133E8FA1C77500D');
        $this->addSql('ALTER TABLE lier DROP id_reseau_id');
        $this->addSql('ALTER TABLE lier DROP id_genre_musical_id');
    }
}
