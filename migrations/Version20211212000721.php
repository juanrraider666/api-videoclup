<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211212000721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film CHANGE film_type_id film_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2225F297B0 FOREIGN KEY (film_type_id) REFERENCES film_type (id)');
        $this->addSql('CREATE INDEX IDX_8244BE2225F297B0 ON film (film_type_id)');
        $this->addSql('ALTER TABLE film_type CHANGE active active TINYINT(1) DEFAULT \'1\' NOT NULL, CHANGE visible visible TINYINT(1) DEFAULT \'0\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE2225F297B0');
        $this->addSql('DROP INDEX IDX_8244BE2225F297B0 ON film');
        $this->addSql('ALTER TABLE film CHANGE film_type_id film_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE film_type CHANGE active active TINYINT(1) NOT NULL, CHANGE visible visible TINYINT(1) DEFAULT NULL');
    }
}
