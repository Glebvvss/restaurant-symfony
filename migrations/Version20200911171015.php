<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200911171015 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E9F85E0677 ON users');
        $this->addSql('ALTER TABLE users CHANGE username username_username VARCHAR(25) NOT NULL, CHANGE email email_email VARCHAR(45) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E18ED12 ON users (username_username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E97ADF3DFB ON users (email_email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E9E18ED12 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E97ADF3DFB ON users');
        $this->addSql('ALTER TABLE users CHANGE username_username username VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email_email email VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }
}
