<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413094853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE adresse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE campus_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE creneau_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE formateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE groupe_promotion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE module_formation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE promotion_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE salle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adresse (id INT NOT NULL, numero VARCHAR(15) NOT NULL, rue VARCHAR(255) NOT NULL, code_postal VARCHAR(10) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE campus (id INT NOT NULL, adresse_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9D0968114DE7DC5C ON campus (adresse_id)');
        $this->addSql('CREATE TABLE creneau (id INT NOT NULL, formateur_id INT DEFAULT NULL, groupe_promotion_id INT DEFAULT NULL, module_formation_id INT DEFAULT NULL, salle_principale_id INT DEFAULT NULL, date_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, commentaire TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F9668B5F155D8F51 ON creneau (formateur_id)');
        $this->addSql('CREATE INDEX IDX_F9668B5F6FCEC350 ON creneau (groupe_promotion_id)');
        $this->addSql('CREATE INDEX IDX_F9668B5F3A53B0DC ON creneau (module_formation_id)');
        $this->addSql('CREATE INDEX IDX_F9668B5FAB3301B9 ON creneau (salle_principale_id)');
        $this->addSql('CREATE TABLE creneau_salle (creneau_id INT NOT NULL, salle_id INT NOT NULL, PRIMARY KEY(creneau_id, salle_id))');
        $this->addSql('CREATE INDEX IDX_5B1949E17D0729A9 ON creneau_salle (creneau_id)');
        $this->addSql('CREATE INDEX IDX_5B1949E1DC304035 ON creneau_salle (salle_id)');
        $this->addSql('CREATE TABLE formateur (id INT NOT NULL, campus_principal_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ED767E4F15C44A32 ON formateur (campus_principal_id)');
        $this->addSql('CREATE TABLE formateur_module_formation (formateur_id INT NOT NULL, module_formation_id INT NOT NULL, PRIMARY KEY(formateur_id, module_formation_id))');
        $this->addSql('CREATE INDEX IDX_4B32469E155D8F51 ON formateur_module_formation (formateur_id)');
        $this->addSql('CREATE INDEX IDX_4B32469E3A53B0DC ON formateur_module_formation (module_formation_id)');
        $this->addSql('CREATE TABLE groupe_promotion (id INT NOT NULL, promotion_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9189AEE6139DF194 ON groupe_promotion (promotion_id)');
        $this->addSql('CREATE TABLE module_formation (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE promotion (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE salle (id INT NOT NULL, campus_id INT DEFAULT NULL, numero VARCHAR(100) NOT NULL, commentaire TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4E977E5CAF5D55E1 ON salle (campus_id)');
        $this->addSql('ALTER TABLE campus ADD CONSTRAINT FK_9D0968114DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F6FCEC350 FOREIGN KEY (groupe_promotion_id) REFERENCES groupe_promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5F3A53B0DC FOREIGN KEY (module_formation_id) REFERENCES module_formation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creneau ADD CONSTRAINT FK_F9668B5FAB3301B9 FOREIGN KEY (salle_principale_id) REFERENCES salle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creneau_salle ADD CONSTRAINT FK_5B1949E17D0729A9 FOREIGN KEY (creneau_id) REFERENCES creneau (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE creneau_salle ADD CONSTRAINT FK_5B1949E1DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4F15C44A32 FOREIGN KEY (campus_principal_id) REFERENCES campus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formateur_module_formation ADD CONSTRAINT FK_4B32469E155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE formateur_module_formation ADD CONSTRAINT FK_4B32469E3A53B0DC FOREIGN KEY (module_formation_id) REFERENCES module_formation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE groupe_promotion ADD CONSTRAINT FK_9189AEE6139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE adresse_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE campus_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE creneau_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE formateur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE groupe_promotion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE module_formation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE promotion_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE salle_id_seq CASCADE');
        $this->addSql('ALTER TABLE campus DROP CONSTRAINT FK_9D0968114DE7DC5C');
        $this->addSql('ALTER TABLE creneau DROP CONSTRAINT FK_F9668B5F155D8F51');
        $this->addSql('ALTER TABLE creneau DROP CONSTRAINT FK_F9668B5F6FCEC350');
        $this->addSql('ALTER TABLE creneau DROP CONSTRAINT FK_F9668B5F3A53B0DC');
        $this->addSql('ALTER TABLE creneau DROP CONSTRAINT FK_F9668B5FAB3301B9');
        $this->addSql('ALTER TABLE creneau_salle DROP CONSTRAINT FK_5B1949E17D0729A9');
        $this->addSql('ALTER TABLE creneau_salle DROP CONSTRAINT FK_5B1949E1DC304035');
        $this->addSql('ALTER TABLE formateur DROP CONSTRAINT FK_ED767E4F15C44A32');
        $this->addSql('ALTER TABLE formateur_module_formation DROP CONSTRAINT FK_4B32469E155D8F51');
        $this->addSql('ALTER TABLE formateur_module_formation DROP CONSTRAINT FK_4B32469E3A53B0DC');
        $this->addSql('ALTER TABLE groupe_promotion DROP CONSTRAINT FK_9189AEE6139DF194');
        $this->addSql('ALTER TABLE salle DROP CONSTRAINT FK_4E977E5CAF5D55E1');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE creneau');
        $this->addSql('DROP TABLE creneau_salle');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE formateur_module_formation');
        $this->addSql('DROP TABLE groupe_promotion');
        $this->addSql('DROP TABLE module_formation');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE salle');
    }
}
