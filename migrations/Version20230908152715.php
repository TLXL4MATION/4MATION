<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908152715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion ADD campus_id INT NOT NULL');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C11D7DD1AF5D55E1 ON promotion (campus_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE promotion DROP CONSTRAINT FK_C11D7DD1AF5D55E1');
        $this->addSql('DROP INDEX IDX_C11D7DD1AF5D55E1');
        $this->addSql('ALTER TABLE promotion DROP campus_id');
    }
}
