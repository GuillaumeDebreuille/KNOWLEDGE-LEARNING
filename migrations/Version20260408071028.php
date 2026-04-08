<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408071028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, lecon_validated TINYINT NOT NULL, formation_validated TINYINT NOT NULL, user_id INT NOT NULL, lecon_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, INDEX IDX_2201F246A76ED395 (user_id), INDEX IDX_2201F246EC1308A5 (lecon_id), INDEX IDX_2201F2465200282E (formation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F246EC1308A5 FOREIGN KEY (lecon_id) REFERENCES lecon (id)');
        $this->addSql('ALTER TABLE progress ADD CONSTRAINT FK_2201F2465200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246A76ED395');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F246EC1308A5');
        $this->addSql('ALTER TABLE progress DROP FOREIGN KEY FK_2201F2465200282E');
        $this->addSql('DROP TABLE progress');
    }
}
