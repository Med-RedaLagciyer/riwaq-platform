<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260311145634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create org_002_user_organisations table linking users to organisations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE org_002_user_organisations (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, user_id UUID NOT NULL, org_id UUID NOT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_BFC58429A76ED395 ON org_002_user_organisations (user_id)');
        $this->addSql('CREATE INDEX IDX_BFC58429F4837C1B ON org_002_user_organisations (org_id)');
        $this->addSql('ALTER TABLE org_002_user_organisations ADD CONSTRAINT FK_BFC58429A76ED395 FOREIGN KEY (user_id) REFERENCES us_001_users (id) NOT DEFERRABLE');
        $this->addSql('ALTER TABLE org_002_user_organisations ADD CONSTRAINT FK_BFC58429F4837C1B FOREIGN KEY (org_id) REFERENCES org_001_organisations (id) NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE org_002_user_organisations DROP CONSTRAINT FK_BFC58429A76ED395');
        $this->addSql('ALTER TABLE org_002_user_organisations DROP CONSTRAINT FK_BFC58429F4837C1B');
        $this->addSql('DROP TABLE org_002_user_organisations');
    }
}
