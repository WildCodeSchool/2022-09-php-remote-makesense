<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221229154300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE timeline ADD decision_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE timeline ADD CONSTRAINT FK_46FEC666BDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id)');
        $this->addSql('CREATE INDEX IDX_46FEC666BDEE7539 ON timeline (decision_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE timeline DROP FOREIGN KEY FK_46FEC666BDEE7539');
        $this->addSql('DROP INDEX IDX_46FEC666BDEE7539 ON timeline');
        $this->addSql('ALTER TABLE timeline DROP decision_id');
    }
}
