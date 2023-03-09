<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230309050739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE leads ALTER guid TYPE UUID');
        $this->addSql('ALTER TABLE leads ALTER person_email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER public_id TYPE UUID');
        $this->addSql('ALTER TABLE users ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER new_email TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE leads ALTER guid TYPE UUID');
        $this->addSql('ALTER TABLE leads ALTER person_email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER public_id TYPE UUID');
        $this->addSql('ALTER TABLE users ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER role TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE users ALTER new_email TYPE VARCHAR(255)');
    }
}
