<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220112163551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE is_service is_service TINYINT(1) NOT NULL, CHANGE is_available_on_site is_available_on_site TINYINT(1) NOT NULL, CHANGE is_available_for_appointment is_available_for_appointment TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product CHANGE is_service is_service TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_available_on_site is_available_on_site TINYINT(1) DEFAULT \'0\' NOT NULL, CHANGE is_available_for_appointment is_available_for_appointment TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
