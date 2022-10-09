<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221009152143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE european_fires_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE european_fires (id SMALLINT NOT NULL, country VARCHAR(3) NOT NULL, year SMALLINT NOT NULL, area NUMERIC(15, 2) NOT NULL, burnt_area INT NOT NULL, nb SMALLINT NOT NULL, data JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX european_fires_idx_country ON european_fires (country)');
        $this->addSql('CREATE INDEX european_fires_idx_year ON european_fires (year)');

        $this->addSql("INSERT INTO data_types (id, code, title, comment, last_synchro) VALUES (nextval('data_types_id_seq'), 'EU-FIRE', 'Incendies de forêts en Europe', 'Refresh chaque jour', '[]');");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE european_fires_id_seq CASCADE');
        $this->addSql('DROP TABLE european_fires');

        $this->addSql('DELETE FROM data_types WHERE code = \'EU-FIRE\'');
    }
}
