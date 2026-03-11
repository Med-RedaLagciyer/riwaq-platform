<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311121719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create us_005_user_security table with login tracking, email throttling, and 2FA fields';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_005_user_security (failed_login_count INT NOT NULL, last_failed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, locked_until TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, email_send_count INT NOT NULL, last_email_sent_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password_reset_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, last_password_changed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_two_factor_enabled BOOLEAN NOT NULL, two_factor_secret VARCHAR(255) DEFAULT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3E634633A76ED395 ON us_005_user_security (user_id)');
        $this->addSql('ALTER TABLE us_005_user_security ADD CONSTRAINT FK_3E634633A76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_005_user_security DROP CONSTRAINT FK_3E634633A76ED395');
        $this->addSql('DROP TABLE us_005_user_security');
    }
}
