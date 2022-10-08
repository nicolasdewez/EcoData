<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220918191702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Data types and synchro';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE data_types_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE synchros_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data_types (id SMALLINT NOT NULL, code VARCHAR(30) NOT NULL, title VARCHAR(150) NOT NULL, comment VARCHAR(255) NOT NULL, last_synchro JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX data_types_idx_code ON data_types (code)');
        $this->addSql('CREATE INDEX data_types_idx_title ON data_types (title)');
        $this->addSql('CREATE TABLE synchros (id INT NOT NULL, data_type_id SMALLINT DEFAULT NULL, user_id SMALLINT NOT NULL, nb_steps SMALLINT NOT NULL, nb_steps_processed SMALLINT NOT NULL, state VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_50EF8B69A147DA62 ON synchros (data_type_id)');
        $this->addSql('CREATE INDEX IDX_50EF8B69A76ED395 ON synchros (user_id)');
        $this->addSql('CREATE INDEX synchros_idx_state ON synchros (state)');
        $this->addSql('COMMENT ON COLUMN synchros.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE synchros ADD CONSTRAINT FK_E5902525A147DA62 FOREIGN KEY (data_type_id) REFERENCES data_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE synchros ADD CONSTRAINT FK_E5902525A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ALTER id TYPE SMALLINT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE data_types_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE synchros_id_seq CASCADE');
        $this->addSql('ALTER TABLE synchros DROP CONSTRAINT FK_E5902525A147DA62');
        $this->addSql('ALTER TABLE synchros DROP CONSTRAINT FK_E5902525A76ED395');
        $this->addSql('DROP TABLE data_types');
        $this->addSql('DROP TABLE synchros');
        $this->addSql('ALTER TABLE users ALTER id TYPE INT');
    }
}
