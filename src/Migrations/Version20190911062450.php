<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190911062450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, city_id INT DEFAULT NULL, duration TIME DEFAULT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_AC74095A8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, contry_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_2D5B0234CD33232C (contry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, continent_id INT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_5373C966921F4C77 (continent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hosting (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, price_per_night DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_E9168FDA8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE month (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, name DATETIME NOT NULL, temperature_avg INT NOT NULL, INDEX IDX_8EB6100681C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, city_departure_id INT NOT NULL, city_arrival_id INT NOT NULL, transport VARCHAR(255) NOT NULL, duration TIME NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_7656F53BE7984489 (city_departure_id), INDEX IDX_7656F53BF0127FF (city_arrival_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234CD33232C FOREIGN KEY (contry_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966921F4C77 FOREIGN KEY (continent_id) REFERENCES continent (id)');
        $this->addSql('ALTER TABLE hosting ADD CONSTRAINT FK_E9168FDA8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE month ADD CONSTRAINT FK_8EB6100681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BE7984489 FOREIGN KEY (city_departure_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BF0127FF FOREIGN KEY (city_arrival_id) REFERENCES city (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE month DROP FOREIGN KEY FK_8EB6100681C06096');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A8BAC62AF');
        $this->addSql('ALTER TABLE hosting DROP FOREIGN KEY FK_E9168FDA8BAC62AF');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BE7984489');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BF0127FF');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234CD33232C');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE hosting');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE trip');
    }
}
