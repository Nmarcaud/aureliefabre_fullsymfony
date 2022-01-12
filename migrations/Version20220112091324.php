<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112091324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD is_service TINYINT(1) DEFAULT \'0\' NOT NULL, ADD duration INT DEFAULT NULL, ADD turnaround_time INT DEFAULT NULL, ADD full_description LONGTEXT DEFAULT NULL, ADD warning_text LONGTEXT DEFAULT NULL, ADD is_available_on_site TINYINT(1) DEFAULT \'0\' NOT NULL, ADD is_available_for_appointment TINYINT(1) DEFAULT \'0\' NOT NULL, ADD modified_at DATETIME DEFAULT NULL, ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP is_service, DROP duration, DROP turnaround_time, DROP full_description, DROP warning_text, DROP is_available_on_site, DROP is_available_for_appointment, DROP modified_at, DROP created_at');
    }
}
