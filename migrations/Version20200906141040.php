<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906141040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserve ADD client_name VARCHAR(30) NOT NULL, ADD reserve_interval_time_from DATETIME NOT NULL, ADD reserve_interval_time_to DATETIME NOT NULL, DROP time_from, DROP time_to');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserve ADD time_from DATETIME NOT NULL, ADD time_to DATETIME NOT NULL, DROP client_name, DROP reserve_interval_time_from, DROP reserve_interval_time_to');
    }
}
