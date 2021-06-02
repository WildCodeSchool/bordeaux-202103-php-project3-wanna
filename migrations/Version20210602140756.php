<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602140756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE401D2EC9');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649401D2EC9');
        $this->addSql('DROP TABLE project_role');
        $this->addSql('DROP INDEX IDX_2FB3D0EE401D2EC9 ON project');
        $this->addSql('ALTER TABLE project DROP project_role_id');
        $this->addSql('DROP INDEX IDX_8D93D649401D2EC9 ON user');
        $this->addSql('ALTER TABLE user DROP project_role_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_role (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE project ADD project_role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE401D2EC9 FOREIGN KEY (project_role_id) REFERENCES project_role (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE401D2EC9 ON project (project_role_id)');
        $this->addSql('ALTER TABLE user ADD project_role_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649401D2EC9 FOREIGN KEY (project_role_id) REFERENCES project_role (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_8D93D649401D2EC9 ON user (project_role_id)');
    }
}
