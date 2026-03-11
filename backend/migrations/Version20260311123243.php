<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311123243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create us_006_user_profiles table with personal info, location, timezone, and language';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_006_user_profiles (first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, avatar_path VARCHAR(255) DEFAULT NULL, bio TEXT DEFAULT NULL, headline VARCHAR(150) DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, date_of_birth DATE DEFAULT NULL, gender VARCHAR(20) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, address TEXT DEFAULT NULL, timezone VARCHAR(50) DEFAULT NULL, language VARCHAR(10) DEFAULT NULL, is_complete BOOLEAN NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_61B57CBBA76ED395 ON us_006_user_profiles (user_id)');
        $this->addSql('ALTER TABLE us_006_user_profiles ADD CONSTRAINT FK_61B57CBBA76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_006_user_profiles DROP CONSTRAINT FK_61B57CBBA76ED395');
        $this->addSql('DROP TABLE us_006_user_profiles');
    }
}
