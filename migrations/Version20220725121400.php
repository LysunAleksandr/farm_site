<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220725121400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket_position ADD beds_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket_position ADD CONSTRAINT FK_2283EB255544DE86 FOREIGN KEY (beds_id) REFERENCES rent_beds (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2283EB255544DE86 ON basket_position (beds_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE basket_position DROP CONSTRAINT FK_2283EB255544DE86');
        $this->addSql('DROP INDEX IDX_2283EB255544DE86');
        $this->addSql('ALTER TABLE basket_position DROP beds_id');
    }
}
