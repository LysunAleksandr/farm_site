<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222121439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog DROP CONSTRAINT fk_1b2c324728cd3df6');
        $this->addSql('DROP INDEX idx_1b2c324728cd3df6');
        $this->addSql('ALTER TABLE catalog DROP ingridient1_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog ADD ingridient1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT fk_1b2c324728cd3df6 FOREIGN KEY (ingridient1_id) REFERENCES ingridient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1b2c324728cd3df6 ON catalog (ingridient1_id)');
    }
}
