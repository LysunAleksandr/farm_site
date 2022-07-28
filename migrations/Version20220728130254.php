<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220728130254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE plant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE plant (id INT NOT NULL, catalog_id INT DEFAULT NULL, bed_id INT DEFAULT NULL, users_id INT DEFAULT NULL, quantity INT DEFAULT NULL, date_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB030D72CC3C66FC ON plant (catalog_id)');
        $this->addSql('CREATE INDEX IDX_AB030D7288688BB9 ON plant (bed_id)');
        $this->addSql('CREATE INDEX IDX_AB030D7267B3B43D ON plant (users_id)');
        $this->addSql('COMMENT ON COLUMN plant.date_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN plant.date_end IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D72CC3C66FC FOREIGN KEY (catalog_id) REFERENCES catalog (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D7288688BB9 FOREIGN KEY (bed_id) REFERENCES rent_beds (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE plant ADD CONSTRAINT FK_AB030D7267B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE plant_id_seq CASCADE');
        $this->addSql('DROP TABLE plant');
    }
}
