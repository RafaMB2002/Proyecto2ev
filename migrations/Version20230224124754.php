<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224124754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evento (id INT AUTO_INCREMENT NOT NULL, juego_id INT NOT NULL, fecha_hora DATETIME NOT NULL, editorial VARCHAR(255) NOT NULL, nombre_juego VARCHAR(255) NOT NULL, num_socios INT NOT NULL, UNIQUE INDEX UNIQ_47860B0513375255 (juego_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitacion (id INT AUTO_INCREMENT NOT NULL, evento_id INT NOT NULL, usuario_id INT NOT NULL, presentado TINYINT(1) DEFAULT NULL, INDEX IDX_3CD30E8487A5F842 (evento_id), INDEX IDX_3CD30E84DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evento ADD CONSTRAINT FK_47860B0513375255 FOREIGN KEY (juego_id) REFERENCES juego (id)');
        $this->addSql('ALTER TABLE invitacion ADD CONSTRAINT FK_3CD30E8487A5F842 FOREIGN KEY (evento_id) REFERENCES evento (id)');
        $this->addSql('ALTER TABLE invitacion ADD CONSTRAINT FK_3CD30E84DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evento DROP FOREIGN KEY FK_47860B0513375255');
        $this->addSql('ALTER TABLE invitacion DROP FOREIGN KEY FK_3CD30E8487A5F842');
        $this->addSql('ALTER TABLE invitacion DROP FOREIGN KEY FK_3CD30E84DB38439E');
        $this->addSql('DROP TABLE evento');
        $this->addSql('DROP TABLE invitacion');
    }
}
