<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211219121232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, date_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, username VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, telehhone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "order".date_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE basket_position ADD order_n_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket_position ADD CONSTRAINT FK_2283EB252E4C7919 FOREIGN KEY (order_n_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2283EB252E4C7919 ON basket_position (order_n_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE basket_position DROP CONSTRAINT FK_2283EB252E4C7919');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP INDEX IDX_2283EB252E4C7919');
        $this->addSql('ALTER TABLE basket_position DROP order_n_id');
    }
}
