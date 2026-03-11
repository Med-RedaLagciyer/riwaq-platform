<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311111928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create us_003_user_status_log table with foreign keys to users and user_status';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_003_user_status_log (notes TEXT DEFAULT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, status_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_B9E83556A76ED395 ON us_003_user_status_log (user_id)');
        $this->addSql('CREATE INDEX IDX_B9E835566BF700BD ON us_003_user_status_log (status_id)');
        $this->addSql('ALTER TABLE us_003_user_status_log ADD CONSTRAINT FK_B9E83556A76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_003_user_status_log ADD CONSTRAINT FK_B9E835566BF700BD FOREIGN KEY (status_id) REFERENCES us_002_user_status (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_003_user_status_log DROP CONSTRAINT FK_B9E83556A76ED395');
        $this->addSql('ALTER TABLE us_003_user_status_log DROP CONSTRAINT FK_B9E835566BF700BD');
        $this->addSql('DROP TABLE us_003_user_status_log');
    }
}
