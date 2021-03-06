<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916142036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserve (id INT AUTO_INCREMENT NOT NULL, table_id INT DEFAULT NULL, client_name VARCHAR(30) NOT NULL, reserve_interval_time_from DATETIME NOT NULL, reserve_interval_time_to DATETIME NOT NULL, INDEX IDX_1FE0EA22ECFF285C (table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, hall_id INT DEFAULT NULL, number INT NOT NULL, INDEX IDX_F6298F4652AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(255) NOT NULL, username_username VARCHAR(25) NOT NULL, email_email VARCHAR(45) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E18ED12 (username_username), UNIQUE INDEX UNIQ_1483A5E97ADF3DFB (email_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserve ADD CONSTRAINT FK_1FE0EA22ECFF285C FOREIGN KEY (table_id) REFERENCES `table` (id)');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT FK_F6298F4652AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY FK_F6298F4652AFCFD6');
        $this->addSql('ALTER TABLE reserve DROP FOREIGN KEY FK_1FE0EA22ECFF285C');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE reserve');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP TABLE users');
    }
}
