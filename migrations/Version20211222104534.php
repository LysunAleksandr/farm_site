<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222104534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog ADD ingridient1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE catalog ADD CONSTRAINT FK_1B2C324728CD3DF6 FOREIGN KEY (ingridient1_id) REFERENCES ingridient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1B2C324728CD3DF6 ON catalog (ingridient1_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog DROP CONSTRAINT FK_1B2C324728CD3DF6');
        $this->addSql('DROP INDEX IDX_1B2C324728CD3DF6');
        $this->addSql('ALTER TABLE catalog DROP ingridient1_id');
    }
}
