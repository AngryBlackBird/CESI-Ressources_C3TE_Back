<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118104308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, resource_id INT NOT NULL, type_file_id INT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_8C9F361089329D25 (resource_id), INDEX IDX_8C9F3610BBEA1699 (type_file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F361089329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610BBEA1699 FOREIGN KEY (type_file_id) REFERENCES file_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F361089329D25');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610BBEA1699');
        $this->addSql('DROP TABLE file');
    }
}
