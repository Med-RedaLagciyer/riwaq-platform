<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311110652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create us_001_users table with UUID v7, roles, and foreign key to us_002_user_status';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_001_users (email VARCHAR(180) NOT NULL, username VARCHAR(50) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) DEFAULT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, current_status_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62720C23E7927C74 ON us_001_users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62720C23F85E0677 ON us_001_users (username)');
        $this->addSql('CREATE INDEX IDX_62720C23B0D1B111 ON us_001_users (current_status_id)');
        $this->addSql('ALTER TABLE us_001_users ADD CONSTRAINT FK_62720C23B0D1B111 FOREIGN KEY (current_status_id) REFERENCES us_002_user_status (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_001_users DROP CONSTRAINT FK_62720C23B0D1B111');
        $this->addSql('DROP TABLE us_001_users');
    }
}
