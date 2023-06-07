<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606135151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE formateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX uniq_ed767e4fe7927c74');
        $this->addSql('ALTER TABLE formateur ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formateur DROP email');
        $this->addSql('ALTER TABLE formateur DROP roles');
        $this->addSql('ALTER TABLE formateur DROP password');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED767E4FFB88E14F ON formateur (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE formateur_id_seq CASCADE');
        $this->addSql('ALTER TABLE formateur DROP CONSTRAINT FK_ED767E4FFB88E14F');
        $this->addSql('DROP INDEX UNIQ_ED767E4FFB88E14F');
        $this->addSql('ALTER TABLE formateur ADD email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE formateur ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE formateur ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE formateur DROP utilisateur_id');
        $this->addSql('CREATE UNIQUE INDEX uniq_ed767e4fe7927c74 ON formateur (email)');
    }
}
