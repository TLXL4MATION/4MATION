<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230825084636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_campus (user_id INT NOT NULL, campus_id INT NOT NULL, PRIMARY KEY(user_id, campus_id))');
        $this->addSql('CREATE INDEX IDX_F85B732CA76ED395 ON user_campus (user_id)');
        $this->addSql('CREATE INDEX IDX_F85B732CAF5D55E1 ON user_campus (campus_id)');
        $this->addSql('ALTER TABLE user_campus ADD CONSTRAINT FK_F85B732CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_campus ADD CONSTRAINT FK_F85B732CAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_campus DROP CONSTRAINT FK_F85B732CA76ED395');
        $this->addSql('ALTER TABLE user_campus DROP CONSTRAINT FK_F85B732CAF5D55E1');
        $this->addSql('DROP TABLE user_campus');
    }
}
