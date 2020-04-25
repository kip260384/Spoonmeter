<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425122235 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE measure_nature (id INT AUTO_INCREMENT NOT NULL, base_unit_id INT NOT NULL, name VARCHAR(16) NOT NULL, UNIQUE INDEX UNIQ_AECE4A67CCBBC969 (base_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE measure_unit (id INT AUTO_INCREMENT NOT NULL, nature_id INT DEFAULT NULL, uniq_name VARCHAR(8) NOT NULL, short_name VARCHAR(8) NOT NULL, name VARCHAR(16) NOT NULL, multiplier DOUBLE PRECISION NOT NULL, INDEX IDX_9B624AE73BCB2E4B (nature_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE substance (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, density INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE measure_nature ADD CONSTRAINT FK_AECE4A67CCBBC969 FOREIGN KEY (base_unit_id) REFERENCES measure_unit (id)');
        $this->addSql('ALTER TABLE measure_unit ADD CONSTRAINT FK_9B624AE73BCB2E4B FOREIGN KEY (nature_id) REFERENCES measure_nature (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE measure_unit DROP FOREIGN KEY FK_9B624AE73BCB2E4B');
        $this->addSql('ALTER TABLE measure_nature DROP FOREIGN KEY FK_AECE4A67CCBBC969');
        $this->addSql('DROP TABLE measure_nature');
        $this->addSql('DROP TABLE measure_unit');
        $this->addSql('DROP TABLE substance');
    }
}
