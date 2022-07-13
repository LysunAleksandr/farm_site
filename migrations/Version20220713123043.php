<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713123043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent_beds ADD photofilename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER INDEX idx_4680c931b81b56d4 RENAME TO IDX_4680C931E289A545');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent_beds DROP photofilename');
        $this->addSql('ALTER INDEX idx_4680c931e289a545 RENAME TO idx_4680c931b81b56d4');
    }
}
