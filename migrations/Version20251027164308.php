<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251027164308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, room_id_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, booked_date DATE NOT NULL, UNIQUE INDEX UNIQ_E00CEDDE35F83FFC (room_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE check_in_out (id INT AUTO_INCREMENT NOT NULL, customer_name_id INT DEFAULT NULL, check_in DATE NOT NULL, check_out DATE NOT NULL, UNIQUE INDEX UNIQ_180E64CD6DCA3868 (customer_name_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rooms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price SMALLINT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE35F83FFC FOREIGN KEY (room_id_id) REFERENCES rooms (id)');
        $this->addSql('ALTER TABLE check_in_out ADD CONSTRAINT FK_180E64CD6DCA3868 FOREIGN KEY (customer_name_id) REFERENCES booking (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE35F83FFC');
        $this->addSql('ALTER TABLE check_in_out DROP FOREIGN KEY FK_180E64CD6DCA3868');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE check_in_out');
        $this->addSql('DROP TABLE rooms');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
