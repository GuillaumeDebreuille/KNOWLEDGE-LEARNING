<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224192412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE lecon (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, formation_id_id INT NOT NULL, INDEX IDX_94E6242E9CF0022 (formation_id_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE lecon ADD CONSTRAINT FK_94E6242E9CF0022 FOREIGN KEY (formation_id_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lecon DROP FOREIGN KEY FK_94E6242E9CF0022');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE lecon');
    }
}
