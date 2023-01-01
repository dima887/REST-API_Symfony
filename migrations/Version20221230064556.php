<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221230064556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL');
        $this->addSql('INSERT INTO user (email, username, roles, password) VALUES ( "admin@mail.ru", "admin@mail.ru", ?, "$2y$13$bYdVf916TfA8pQL0voayFunn0HIMs1iKr5JvdR1xXXWZ24jtd7y0i");', [json_encode(['ROLE_ADMIN'])]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name, DROP phone');
    }
}
