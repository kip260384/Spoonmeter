<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200417182448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE aggregation_state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE substance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE substance_properties (id INT AUTO_INCREMENT NOT NULL, substance_id_id INT NOT NULL, aggregation_state_id_id INT NOT NULL, density INT NOT NULL, INDEX IDX_C7D8F130B46E5170 (substance_id_id), INDEX IDX_C7D8F130586EF0AF (aggregation_state_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE volume (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, ml INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE volume_subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weight (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, mg INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE substance_properties ADD CONSTRAINT FK_C7D8F130B46E5170 FOREIGN KEY (substance_id_id) REFERENCES substance (id)');
        $this->addSql('ALTER TABLE substance_properties ADD CONSTRAINT FK_C7D8F130586EF0AF FOREIGN KEY (aggregation_state_id_id) REFERENCES aggregation_state (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE substance_properties DROP FOREIGN KEY FK_C7D8F130586EF0AF');
        $this->addSql('ALTER TABLE substance_properties DROP FOREIGN KEY FK_C7D8F130B46E5170');
        $this->addSql('DROP TABLE aggregation_state');
        $this->addSql('DROP TABLE substance');
        $this->addSql('DROP TABLE substance_properties');
        $this->addSql('DROP TABLE volume');
        $this->addSql('DROP TABLE volume_subject');
        $this->addSql('DROP TABLE weight');
    }
}
