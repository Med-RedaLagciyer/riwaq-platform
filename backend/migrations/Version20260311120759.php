<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311120759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create us_004_user_login_log table for tracking login events, device info and suspicious activity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_004_user_login_log (ip_address VARCHAR(45) NOT NULL, user_agent TEXT DEFAULT NULL, device_type VARCHAR(50) DEFAULT NULL, browser VARCHAR(100) DEFAULT NULL, os VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, is_suspicious BOOLEAN NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_C4D65CDA76ED395 ON us_004_user_login_log (user_id)');
        $this->addSql('ALTER TABLE us_004_user_login_log ADD CONSTRAINT FK_C4D65CDA76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_004_user_login_log DROP CONSTRAINT FK_C4D65CDA76ED395');
        $this->addSql('DROP TABLE us_004_user_login_log');
    }
}
