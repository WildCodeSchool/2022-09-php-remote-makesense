<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216092359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE decision ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE decision ADD CONSTRAINT FK_84ACBE48A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_84ACBE48A76ED395 ON decision (user_id)');
        $this->addSql('ALTER TABLE notification ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAA76ED395 ON notification (user_id)');
        $this->addSql('ALTER TABLE user ADD langage_id INT DEFAULT NULL, ADD employee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649957BB53C FOREIGN KEY (langage_id) REFERENCES langage (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649957BB53C ON user (langage_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498C03F15C ON user (employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE decision DROP FOREIGN KEY FK_84ACBE48A76ED395');
        $this->addSql('DROP INDEX IDX_84ACBE48A76ED395 ON decision');
        $this->addSql('ALTER TABLE decision DROP user_id');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('DROP INDEX IDX_BF5476CAA76ED395 ON notification');
        $this->addSql('ALTER TABLE notification DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649957BB53C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498C03F15C');
        $this->addSql('DROP INDEX IDX_8D93D649957BB53C ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D6498C03F15C ON user');
        $this->addSql('ALTER TABLE user DROP langage_id, DROP employee_id');
    }
}
