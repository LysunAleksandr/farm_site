<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222123433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket_position_ingridient (basket_position_id INT NOT NULL, ingridient_id INT NOT NULL, PRIMARY KEY(basket_position_id, ingridient_id))');
        $this->addSql('CREATE INDEX IDX_A364C4C191FCB9A4 ON basket_position_ingridient (basket_position_id)');
        $this->addSql('CREATE INDEX IDX_A364C4C1750B1398 ON basket_position_ingridient (ingridient_id)');
        $this->addSql('ALTER TABLE basket_position_ingridient ADD CONSTRAINT FK_A364C4C191FCB9A4 FOREIGN KEY (basket_position_id) REFERENCES basket_position (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE basket_position_ingridient ADD CONSTRAINT FK_A364C4C1750B1398 FOREIGN KEY (ingridient_id) REFERENCES ingridient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE basket_position_ingridient');
    }
}
