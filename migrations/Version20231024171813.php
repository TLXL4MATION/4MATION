<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024171813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D0968116C6E55B5 ON campus (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9189AEE66C6E55B5 ON groupe_promotion (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1A213E776C6E55B5 ON module_formation (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C11D7DD16C6E55B5 ON promotion (nom)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_9189AEE66C6E55B5');
        $this->addSql('DROP INDEX UNIQ_1A213E776C6E55B5');
        $this->addSql('DROP INDEX UNIQ_9D0968116C6E55B5');
        $this->addSql('DROP INDEX UNIQ_C11D7DD16C6E55B5');
    }
}
