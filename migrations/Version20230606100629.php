<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606100629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE formateur_id_seq CASCADE');
        $this->addSql('ALTER TABLE formateur ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE formateur ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE formateur ADD password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED767E4FE7927C74 ON formateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE formateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX UNIQ_ED767E4FE7927C74');
        $this->addSql('ALTER TABLE formateur DROP email');
        $this->addSql('ALTER TABLE formateur DROP roles');
        $this->addSql('ALTER TABLE formateur DROP password');
    }
}
