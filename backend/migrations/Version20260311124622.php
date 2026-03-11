<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311124622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create us_007_user_tokens table for email verification, password reset, magic links, and invitations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_007_user_tokens (type VARCHAR(50) NOT NULL, token VARCHAR(64) NOT NULL, context JSON DEFAULT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, used_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_CC0F707BA76ED395 ON us_007_user_tokens (user_id)');
        $this->addSql('ALTER TABLE us_007_user_tokens ADD CONSTRAINT FK_CC0F707BA76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_007_user_tokens DROP CONSTRAINT FK_CC0F707BA76ED395');
        $this->addSql('DROP TABLE us_007_user_tokens');
    }
}
