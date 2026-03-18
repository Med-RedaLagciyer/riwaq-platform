<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260318144212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE us_009_pages (label VARCHAR(100) NOT NULL, path VARCHAR(255) DEFAULT NULL, icon VARCHAR(100) DEFAULT NULL, "order" SMALLINT DEFAULT 0 NOT NULL, id UUID NOT NULL, parent_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_656A02D8727ACA70 ON us_009_pages (parent_id)');
        $this->addSql('CREATE TABLE us_010_actions (class_name VARCHAR(100) DEFAULT NULL, id_tag VARCHAR(100) DEFAULT NULL, label VARCHAR(100) NOT NULL, id UUID NOT NULL, page_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_63EEDCEBC4663E4 ON us_010_actions (page_id)');
        $this->addSql('CREATE TABLE us_011_user_actions (user_id UUID NOT NULL, action_id UUID NOT NULL, PRIMARY KEY (user_id, action_id))');
        $this->addSql('CREATE INDEX IDX_89C03243A76ED395 ON us_011_user_actions (user_id)');
        $this->addSql('CREATE INDEX IDX_89C032439D32F035 ON us_011_user_actions (action_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89C03243A76ED3959D32F035 ON us_011_user_actions (user_id, action_id)');
        $this->addSql('ALTER TABLE us_009_pages ADD CONSTRAINT FK_656A02D8727ACA70 FOREIGN KEY (parent_id) REFERENCES us_009_pages (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_010_actions ADD CONSTRAINT FK_63EEDCEBC4663E4 FOREIGN KEY (page_id) REFERENCES us_009_pages (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_011_user_actions ADD CONSTRAINT FK_89C03243A76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE us_011_user_actions ADD CONSTRAINT FK_89C032439D32F035 FOREIGN KEY (action_id) REFERENCES us_010_actions (id) ON DELETE CASCADE NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_009_pages DROP CONSTRAINT FK_656A02D8727ACA70');
        $this->addSql('ALTER TABLE us_010_actions DROP CONSTRAINT FK_63EEDCEBC4663E4');
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT FK_89C03243A76ED395');
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT FK_89C032439D32F035');
        $this->addSql('DROP TABLE us_009_pages');
        $this->addSql('DROP TABLE us_010_actions');
        $this->addSql('DROP TABLE us_011_user_actions');
    }
}
