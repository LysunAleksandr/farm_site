<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726124832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT fk_f529939877f5180b');
        $this->addSql('DROP INDEX idx_f529939877f5180b');
        $this->addSql('ALTER TABLE "order" DROP client_contact_id');
        $this->addSql('ALTER TABLE "order" DROP adress');
        $this->addSql('ALTER TABLE "order" DROP telehhone');
        $this->addSql('ALTER TABLE "order" DROP session_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" ADD client_contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "order" ADD adress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD telehhone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD session_id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT fk_f529939877f5180b FOREIGN KEY (client_contact_id) REFERENCES client_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f529939877f5180b ON "order" (client_contact_id)');
    }
}
