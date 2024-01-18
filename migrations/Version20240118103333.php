<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118103333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, comment_id INT NOT NULL, report_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', reason LONGTEXT NOT NULL, INDEX IDX_C42F7784F675F31B (author_id), INDEX IDX_C42F7784F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE share (id INT AUTO_INCREMENT NOT NULL, resource_id INT NOT NULL, share_by_id INT NOT NULL, INDEX IDX_EF069D5A89329D25 (resource_id), INDEX IDX_EF069D5A2389CCE9 (share_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE share_user (share_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3054DBD02AE63FDB (share_id), INDEX IDX_3054DBD0A76ED395 (user_id), PRIMARY KEY(share_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_resource (user_id INT NOT NULL, resource_id INT NOT NULL, INDEX IDX_5C1C1016A76ED395 (user_id), INDEX IDX_5C1C101689329D25 (resource_id), PRIMARY KEY(user_id, resource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5A89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5A2389CCE9 FOREIGN KEY (share_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE share_user ADD CONSTRAINT FK_3054DBD02AE63FDB FOREIGN KEY (share_id) REFERENCES share (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE share_user ADD CONSTRAINT FK_3054DBD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_resource ADD CONSTRAINT FK_5C1C1016A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_resource ADD CONSTRAINT FK_5C1C101689329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE role');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784F675F31B');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784F8697D13');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5A89329D25');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5A2389CCE9');
        $this->addSql('ALTER TABLE share_user DROP FOREIGN KEY FK_3054DBD02AE63FDB');
        $this->addSql('ALTER TABLE share_user DROP FOREIGN KEY FK_3054DBD0A76ED395');
        $this->addSql('ALTER TABLE user_resource DROP FOREIGN KEY FK_5C1C1016A76ED395');
        $this->addSql('ALTER TABLE user_resource DROP FOREIGN KEY FK_5C1C101689329D25');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE share');
        $this->addSql('DROP TABLE share_user');
        $this->addSql('DROP TABLE user_resource');
    }
}
