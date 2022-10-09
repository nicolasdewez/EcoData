<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918192533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Piezometry';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE piezometry_measurements_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE piezometry_stations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE piezometry_measurements (id INT NOT NULL, station_id SMALLINT DEFAULT NULL, date DATE NOT NULL, value NUMERIC(10, 2) NOT NULL, data JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_90AB130921BDB235 ON piezometry_measurements (station_id)');
        $this->addSql('CREATE INDEX piezometry_measurements_idx_date ON piezometry_measurements (date)');
        $this->addSql('COMMENT ON COLUMN piezometry_measurements.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE piezometry_stations (id SMALLINT NOT NULL, external_code VARCHAR(50) NOT NULL, title VARCHAR(250) DEFAULT NULL, city VARCHAR(250) DEFAULT NULL, code_department VARCHAR(10) DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, data JSON NOT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX piezometry_stations_idx_title ON piezometry_stations (title)');
        $this->addSql('CREATE INDEX piezometry_stations_idx_external_code ON piezometry_stations (external_code)');
        $this->addSql('CREATE INDEX piezometry_stations_idx_city ON piezometry_stations (city)');
        $this->addSql('CREATE INDEX piezometry_stations_idx_code_department ON piezometry_stations (code_department)');
        $this->addSql('CREATE INDEX piezometry_stations_idx_start_date ON piezometry_stations (start_date)');
        $this->addSql('CREATE INDEX piezometry_stations_idx_end_date ON piezometry_stations (end_date)');
        $this->addSql('CREATE INDEX piezometry_stations_idx_enabled ON piezometry_stations (enabled)');
        $this->addSql('COMMENT ON COLUMN piezometry_stations.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN piezometry_stations.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE piezometry_measurements ADD CONSTRAINT FK_90AB130921BDB235 FOREIGN KEY (station_id) REFERENCES piezometry_stations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql("INSERT INTO data_types (id, code, title, comment, last_synchro) VALUES (nextval('data_types_id_seq'), 'PIEZO', 'Piezometrie - Nappes phréatiques', 'Refresh chaque jour', '[]');");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE piezometry_measurements_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE piezometry_stations_id_seq CASCADE');
        $this->addSql('ALTER TABLE piezometry_measurements DROP CONSTRAINT FK_90AB130921BDB235');
        $this->addSql('DROP TABLE piezometry_measurements');
        $this->addSql('DROP TABLE piezometry_stations');

        $this->addSql('DELETE FROM data_types WHERE code = \'PIEZO\'');
    }
}
