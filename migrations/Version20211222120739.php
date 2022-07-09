<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222120739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog_ingridient (catalog_id INT NOT NULL, ingridient_id INT NOT NULL, PRIMARY KEY(catalog_id, ingridient_id))');
        $this->addSql('CREATE INDEX IDX_A9474AD0CC3C66FC ON catalog_ingridient (catalog_id)');
        $this->addSql('CREATE INDEX IDX_A9474AD0750B1398 ON catalog_ingridient (ingridient_id)');
        $this->addSql('ALTER TABLE catalog_ingridient ADD CONSTRAINT FK_A9474AD0CC3C66FC FOREIGN KEY (catalog_id) REFERENCES catalog (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE catalog_ingridient ADD CONSTRAINT FK_A9474AD0750B1398 FOREIGN KEY (ingridient_id) REFERENCES ingridient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE catalog_ingridient');
    }
}
