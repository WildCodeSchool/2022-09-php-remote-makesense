<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214221822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributor ADD employee_id INT DEFAULT NULL, ADD decision_id INT DEFAULT NULL, ADD implication_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F97938C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793BDEE7539 FOREIGN KEY (decision_id) REFERENCES decision (id)');
        $this->addSql('ALTER TABLE contributor ADD CONSTRAINT FK_DA6F9793FE71D25F FOREIGN KEY (implication_id) REFERENCES implication (id)');
        $this->addSql('CREATE INDEX IDX_DA6F97938C03F15C ON contributor (employee_id)');
        $this->addSql('CREATE INDEX IDX_DA6F9793BDEE7539 ON contributor (decision_id)');
        $this->addSql('CREATE INDEX IDX_DA6F9793FE71D25F ON contributor (implication_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F97938C03F15C');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793BDEE7539');
        $this->addSql('ALTER TABLE contributor DROP FOREIGN KEY FK_DA6F9793FE71D25F');
        $this->addSql('DROP INDEX IDX_DA6F97938C03F15C ON contributor');
        $this->addSql('DROP INDEX IDX_DA6F9793BDEE7539 ON contributor');
        $this->addSql('DROP INDEX IDX_DA6F9793FE71D25F ON contributor');
        $this->addSql('ALTER TABLE contributor DROP employee_id, DROP decision_id, DROP implication_id');
    }
}
