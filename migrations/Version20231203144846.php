<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231203144846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_session (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, session_id INT DEFAULT NULL, is_task_completed TINYINT(1) NOT NULL, INDEX IDX_CFA5FF3E8DB60186 (task_id), INDEX IDX_CFA5FF3E613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_session ADD CONSTRAINT FK_CFA5FF3E8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE task_session ADD CONSTRAINT FK_CFA5FF3E613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task_session DROP FOREIGN KEY FK_CFA5FF3E8DB60186');
        $this->addSql('ALTER TABLE task_session DROP FOREIGN KEY FK_CFA5FF3E613FECDF');
        $this->addSql('DROP TABLE task_session');
    }
}
