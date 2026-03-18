<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260318145022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT us_011_user_actions_pkey');
        $this->addSql('DROP INDEX uniq_89c03243a76ed3959d32f035');
        $this->addSql('ALTER TABLE us_011_user_actions ADD org_id UUID NOT NULL');
        $this->addSql('ALTER TABLE us_011_user_actions ADD CONSTRAINT FK_89C03243F4837C1B FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_89C03243F4837C1B ON us_011_user_actions (org_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_89C03243A76ED3959D32F035F4837C1B ON us_011_user_actions (user_id, action_id, org_id)');
        $this->addSql('ALTER TABLE us_011_user_actions ADD PRIMARY KEY (user_id, action_id, org_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT FK_89C03243F4837C1B');
        $this->addSql('DROP INDEX IDX_89C03243F4837C1B');
        $this->addSql('ALTER TABLE us_011_user_actions DROP CONSTRAINT us_011_user_actions_pkey');
        $this->addSql('DROP INDEX UNIQ_89C03243A76ED3959D32F035F4837C1B');
        $this->addSql('ALTER TABLE us_011_user_actions DROP org_id');
        $this->addSql('CREATE UNIQUE INDEX uniq_89c03243a76ed3959d32f035 ON us_011_user_actions (user_id, action_id)');
        $this->addSql('ALTER TABLE us_011_user_actions ADD PRIMARY KEY (user_id, action_id)');
    }
}
