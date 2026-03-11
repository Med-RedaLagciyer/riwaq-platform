<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311145437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create org_001_organisations table with owner foreign key and unique slug';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE org_001_organisations (name VARCHAR(150) NOT NULL, slug VARCHAR(150) NOT NULL, is_active BOOLEAN NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, owner_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3C6E6247989D9B62 ON org_001_organisations (slug)');
        $this->addSql('CREATE INDEX IDX_3C6E62477E3C61F9 ON org_001_organisations (owner_id)');
        $this->addSql('ALTER TABLE org_001_organisations ADD CONSTRAINT FK_3C6E62477E3C61F9 FOREIGN KEY (owner_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org_001_organisations DROP CONSTRAINT FK_3C6E62477E3C61F9');
        $this->addSql('DROP TABLE org_001_organisations');
    }
}
