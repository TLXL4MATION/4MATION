<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825090027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formateur DROP CONSTRAINT fk_ed767e4f15c44a32');
        $this->addSql('DROP INDEX idx_ed767e4f15c44a32');
        $this->addSql('ALTER TABLE formateur DROP campus_principal_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE formateur ADD campus_principal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT fk_ed767e4f15c44a32 FOREIGN KEY (campus_principal_id) REFERENCES campus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ed767e4f15c44a32 ON formateur (campus_principal_id)');
    }
}
