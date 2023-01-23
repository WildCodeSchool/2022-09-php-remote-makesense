<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221220092444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contribution ADD decision_id INT DEFAULT NULL, ADD contributor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15BDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E157A19A357 FOREIGN KEY (contributor_id) REFERENCES contributor (id)');
        $this->addSql('CREATE INDEX IDX_EA351E15BDEE7539 ON contribution (decision_id)');
        $this->addSql('CREATE INDEX IDX_EA351E157A19A357 ON contribution (contributor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E15BDEE7539');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E157A19A357');
        $this->addSql('DROP INDEX IDX_EA351E15BDEE7539 ON contribution');
        $this->addSql('DROP INDEX IDX_EA351E157A19A357 ON contribution');
        $this->addSql('ALTER TABLE contribution DROP decision_id, DROP contributor_id');
    }
}
