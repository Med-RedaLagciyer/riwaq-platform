<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319104640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE org_002_organisation_details (address VARCHAR(255) DEFAULT NULL, city VARCHAR(100) DEFAULT NULL, country VARCHAR(100) DEFAULT NULL, postal_code VARCHAR(20) DEFAULT NULL, primary_phone VARCHAR(30) DEFAULT NULL, secondary_phone VARCHAR(30) DEFAULT NULL, primary_email VARCHAR(180) DEFAULT NULL, secondary_email VARCHAR(180) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDE8BA40F4837C1B ON org_002_organisation_details (org_id)');
        $this->addSql('CREATE TABLE org_003_organisation_visibility (field VARCHAR(50) NOT NULL, visibility VARCHAR(20) NOT NULL, id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_E93FB019F4837C1B ON org_003_organisation_visibility (org_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E93FB019F4837C1B5BF54558 ON org_003_organisation_visibility (org_id, field)');
        $this->addSql('CREATE TABLE org_004_organisation_members (type VARCHAR(20) NOT NULL, id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_F89F39B5A76ED395 ON org_004_organisation_members (user_id)');
        $this->addSql('CREATE INDEX IDX_F89F39B5F4837C1B ON org_004_organisation_members (org_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F89F39B5A76ED395F4837C1B ON org_004_organisation_members (user_id, org_id)');
        $this->addSql('ALTER TABLE org_002_organisation_details ADD CONSTRAINT FK_BDE8BA40F4837C1B FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE org_003_organisation_visibility ADD CONSTRAINT FK_E93FB019F4837C1B FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE org_004_organisation_members ADD CONSTRAINT FK_F89F39B5A76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE org_004_organisation_members ADD CONSTRAINT FK_F89F39B5F4837C1B FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE org_002_user_organisations DROP CONSTRAINT fk_bfc58429f4837c1b');
        $this->addSql('ALTER TABLE org_002_user_organisations DROP CONSTRAINT fk_bfc58429a76ed395');
        $this->addSql('DROP TABLE org_002_user_organisations');
        $this->addSql('ALTER TABLE org_001_organisations ADD type VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE org_001_organisations ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE org_001_organisations ADD logo_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE org_001_organisations ADD is_verified BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE org_002_user_organisations (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX idx_bfc58429a76ed395 ON org_002_user_organisations (user_id)');
        $this->addSql('CREATE INDEX idx_bfc58429f4837c1b ON org_002_user_organisations (org_id)');
        $this->addSql('ALTER TABLE org_002_user_organisations ADD CONSTRAINT fk_bfc58429f4837c1b FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE org_002_user_organisations ADD CONSTRAINT fk_bfc58429a76ed395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE org_002_organisation_details DROP CONSTRAINT FK_BDE8BA40F4837C1B');
        $this->addSql('ALTER TABLE org_003_organisation_visibility DROP CONSTRAINT FK_E93FB019F4837C1B');
        $this->addSql('ALTER TABLE org_004_organisation_members DROP CONSTRAINT FK_F89F39B5A76ED395');
        $this->addSql('ALTER TABLE org_004_organisation_members DROP CONSTRAINT FK_F89F39B5F4837C1B');
        $this->addSql('DROP TABLE org_002_organisation_details');
        $this->addSql('DROP TABLE org_003_organisation_visibility');
        $this->addSql('DROP TABLE org_004_organisation_members');
        $this->addSql('ALTER TABLE org_001_organisations DROP type');
        $this->addSql('ALTER TABLE org_001_organisations DROP description');
        $this->addSql('ALTER TABLE org_001_organisations DROP logo_path');
        $this->addSql('ALTER TABLE org_001_organisations DROP is_verified');
    }
}
