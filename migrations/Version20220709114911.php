<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220709114911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('DROP TABLE basket_position_ingridient');
        $this->addSql('ALTER TABLE basket_position ADD catalog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket_position ADD CONSTRAINT FK_2283EB25CC3C66FC FOREIGN KEY (catalog_id) REFERENCES catalog (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2283EB25CC3C66FC ON basket_position (catalog_id)');
        $this->addSql('DROP INDEX uniq_8d93d6497ba2f5eb');
        $this->addSql('ALTER TABLE "user" DROP api_token');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE basket_position_ingridient (basket_position_id INT NOT NULL, ingridient_id INT NOT NULL, PRIMARY KEY(basket_position_id, ingridient_id))');
        $this->addSql('CREATE INDEX idx_a364c4c1750b1398 ON basket_position_ingridient (ingridient_id)');
        $this->addSql('CREATE INDEX idx_a364c4c191fcb9a4 ON basket_position_ingridient (basket_position_id)');
        $this->addSql('ALTER TABLE basket_position_ingridient ADD CONSTRAINT fk_a364c4c191fcb9a4 FOREIGN KEY (basket_position_id) REFERENCES basket_position (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE basket_position_ingridient ADD CONSTRAINT fk_a364c4c1750b1398 FOREIGN KEY (ingridient_id) REFERENCES ingridient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE "user" ADD api_token VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d6497ba2f5eb ON "user" (api_token)');
        $this->addSql('ALTER TABLE basket_position DROP CONSTRAINT FK_2283EB25CC3C66FC');
        $this->addSql('DROP INDEX IDX_2283EB25CC3C66FC');
        $this->addSql('ALTER TABLE basket_position DROP catalog_id');
    }
}
