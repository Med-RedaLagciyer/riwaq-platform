<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319100403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_009_user_pages (label VARCHAR(100) NOT NULL, path VARCHAR(255) DEFAULT NULL, icon VARCHAR(100) DEFAULT NULL, sort_order SMALLINT DEFAULT 0 NOT NULL, id UUID NOT NULL, parent_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_9A1F09B1727ACA70 ON us_009_user_pages (parent_id)');
        $this->addSql('CREATE TABLE us_010_user_actions (class_name VARCHAR(100) DEFAULT NULL, id_tag VARCHAR(100) DEFAULT NULL, label VARCHAR(100) NOT NULL, id UUID NOT NULL, page_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_14CFD335C4663E4 ON us_010_user_actions (page_id)');
        $this->addSql('CREATE TABLE us_011_user_action_privileges (user_id UUID NOT NULL, action_id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (user_id, action_id, org_id))');
        $this->addSql('CREATE INDEX IDX_F6B158E3A76ED395 ON us_011_user_action_privileges (user_id)');
        $this->addSql('CREATE INDEX IDX_F6B158E39D32F035 ON us_011_user_action_privileges (action_id)');
        $this->addSql('CREATE INDEX IDX_F6B158E3F4837C1B ON us_011_user_action_privileges (org_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6B158E3A76ED3959D32F035F4837C1B ON us_011_user_action_privileges (user_id, action_id, org_id)');
        $this->addSql('ALTER TABLE us_009_user_pages ADD CONSTRAINT FK_9A1F09B1727ACA70 FOREIGN KEY (parent_id) REFERENCES us_009_user_pages (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_010_user_actions ADD CONSTRAINT FK_14CFD335C4663E4 FOREIGN KEY (page_id) REFERENCES us_009_user_pages (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_011_user_action_privileges ADD CONSTRAINT FK_F6B158E3A76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_011_user_action_privileges ADD CONSTRAINT FK_F6B158E39D32F035 FOREIGN KEY (action_id) REFERENCES us_010_user_actions (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_011_user_action_privileges ADD CONSTRAINT FK_F6B158E3F4837C1B FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_009_pages DROP CONSTRAINT fk_656a02d8727aca70');
        $this->addSql('ALTER TABLE us_010_actions DROP CONSTRAINT fk_63eedcebc4663e4');
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT fk_89c03243a76ed395');
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT fk_89c032439d32f035');
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT fk_89c03243f4837c1b');
        $this->addSql('DROP TABLE us_009_pages');
        $this->addSql('DROP TABLE us_010_actions');
        $this->addSql('DROP TABLE us_011_user_actions');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_009_pages (label VARCHAR(100) NOT NULL, path VARCHAR(255) DEFAULT NULL, icon VARCHAR(100) DEFAULT NULL, sort_order SMALLINT DEFAULT 0 NOT NULL, id UUID NOT NULL, parent_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX idx_656a02d8727aca70 ON us_009_pages (parent_id)');
        $this->addSql('CREATE TABLE us_010_actions (class_name VARCHAR(100) DEFAULT NULL, id_tag VARCHAR(100) DEFAULT NULL, label VARCHAR(100) NOT NULL, id UUID NOT NULL, page_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX idx_63eedcebc4663e4 ON us_010_actions (page_id)');
        $this->addSql('CREATE TABLE us_011_user_actions (user_id UUID NOT NULL, action_id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (user_id, action_id, org_id))');
        $this->addSql('CREATE INDEX idx_89c032439d32f035 ON us_011_user_actions (action_id)');
        $this->addSql('CREATE INDEX idx_89c03243f4837c1b ON us_011_user_actions (org_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_89c03243a76ed3959d32f035f4837c1b ON us_011_user_actions (user_id, action_id, org_id)');
        $this->addSql('CREATE INDEX idx_89c03243a76ed395 ON us_011_user_actions (user_id)');
        $this->addSql('ALTER TABLE us_009_pages ADD CONSTRAINT fk_656a02d8727aca70 FOREIGN KEY (parent_id) REFERENCES us_009_pages (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE us_010_actions ADD CONSTRAINT fk_63eedcebc4663e4 FOREIGN KEY (page_id) REFERENCES us_009_pages (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE us_011_user_actions ADD CONSTRAINT fk_89c03243a76ed395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE us_011_user_actions ADD CONSTRAINT fk_89c032439d32f035 FOREIGN KEY (action_id) REFERENCES us_010_actions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE us_011_user_actions ADD CONSTRAINT fk_89c03243f4837c1b FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE us_009_user_pages DROP CONSTRAINT FK_9A1F09B1727ACA70');
        $this->addSql('ALTER TABLE us_010_user_actions DROP CONSTRAINT FK_14CFD335C4663E4');
        $this->addSql('ALTER TABLE us_011_user_action_privileges DROP CONSTRAINT FK_F6B158E3A76ED395');
        $this->addSql('ALTER TABLE us_011_user_action_privileges DROP CONSTRAINT FK_F6B158E39D32F035');
        $this->addSql('ALTER TABLE us_011_user_action_privileges DROP CONSTRAINT FK_F6B158E3F4837C1B');
        $this->addSql('DROP TABLE us_009_user_pages');
        $this->addSql('DROP TABLE us_010_user_actions');
        $this->addSql('DROP TABLE us_011_user_action_privileges');
    }
}
