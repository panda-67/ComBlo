<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211017141255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artikel ADD harga VARCHAR(255) DEFAULT NULL, ADD harga_d VARCHAR(255) DEFAULT NULL, CHANGE created_on created_on DATETIME NOT NULL, CHANGE update_on update_on DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artikel DROP harga, DROP harga_d, CHANGE created_on created_on DATETIME NOT NULL, CHANGE update_on update_on DATETIME NOT NULL');
    }
}
