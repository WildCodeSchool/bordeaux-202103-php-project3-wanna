<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624152446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accomplishment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_23A0E66A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_shared TINYINT(1) NOT NULL, INDEX IDX_8C9F3610A76ED395 (user_id), INDEX IDX_8C9F3610166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, receiver_id INT NOT NULL, sender_id INT NOT NULL, content LONGTEXT NOT NULL, is_read TINYINT(1) NOT NULL, sent_at DATETIME NOT NULL, INDEX IDX_B6BD307FCD53EDB6 (receiver_id), INDEX IDX_B6BD307FF624B39D (sender_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, registration_nb VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C1EE637C5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, project_id INT NOT NULL, role VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D79F6B11A76ED395 (user_id), INDEX IDX_D79F6B11166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_sdg (project_id INT NOT NULL, sdg_id INT NOT NULL, INDEX IDX_E9CA8FA0166D1F9C (project_id), INDEX IDX_E9CA8FA06F37DCD9 (sdg_id), PRIMARY KEY(project_id, sdg_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_skill (project_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_4D68EDE9166D1F9C (project_id), INDEX IDX_4D68EDE95585C142 (skill_id), PRIMARY KEY(project_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recommendation (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_433224D2F624B39D (sender_id), INDEX IDX_433224D2CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sdg (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, skill_set_id INT NOT NULL, identifier VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5E3DE4773FB1590C (skill_set_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill_set (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deadline DATETIME DEFAULT NULL, INDEX IDX_527EDB25166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, organization_id INT DEFAULT NULL, country_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64932C8A3DE (organization_id), INDEX IDX_8D93D649F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_language (user_id INT NOT NULL, language_id INT NOT NULL, INDEX IDX_345695B5A76ED395 (user_id), INDEX IDX_345695B582F1BAF4 (language_id), PRIMARY KEY(user_id, language_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_skill (user_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_BCFF1F2FA76ED395 (user_id), INDEX IDX_BCFF1F2F5585C142 (skill_id), PRIMARY KEY(user_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_task (user_id INT NOT NULL, task_id INT NOT NULL, INDEX IDX_28FF97ECA76ED395 (user_id), INDEX IDX_28FF97EC8DB60186 (task_id), PRIMARY KEY(user_id, task_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_accomplishment (user_id INT NOT NULL, accomplishment_id INT NOT NULL, INDEX IDX_C657C47AA76ED395 (user_id), INDEX IDX_C657C47A9DA14546 (accomplishment_id), PRIMARY KEY(user_id, accomplishment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_sdg ADD CONSTRAINT FK_E9CA8FA0166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_sdg ADD CONSTRAINT FK_E9CA8FA06F37DCD9 FOREIGN KEY (sdg_id) REFERENCES sdg (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_skill ADD CONSTRAINT FK_4D68EDE9166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_skill ADD CONSTRAINT FK_4D68EDE95585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recommendation ADD CONSTRAINT FK_433224D2F624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recommendation ADD CONSTRAINT FK_433224D2CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4773FB1590C FOREIGN KEY (skill_set_id) REFERENCES skill_set (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64932C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_language ADD CONSTRAINT FK_345695B582F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_skill ADD CONSTRAINT FK_BCFF1F2F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_task ADD CONSTRAINT FK_28FF97ECA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_task ADD CONSTRAINT FK_28FF97EC8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_accomplishment ADD CONSTRAINT FK_C657C47AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_accomplishment ADD CONSTRAINT FK_C657C47A9DA14546 FOREIGN KEY (accomplishment_id) REFERENCES accomplishment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_accomplishment DROP FOREIGN KEY FK_C657C47A9DA14546');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F92F3E70');
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B582F1BAF4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64932C8A3DE');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610166D1F9C');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11166D1F9C');
        $this->addSql('ALTER TABLE project_sdg DROP FOREIGN KEY FK_E9CA8FA0166D1F9C');
        $this->addSql('ALTER TABLE project_skill DROP FOREIGN KEY FK_4D68EDE9166D1F9C');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE project_sdg DROP FOREIGN KEY FK_E9CA8FA06F37DCD9');
        $this->addSql('ALTER TABLE project_skill DROP FOREIGN KEY FK_4D68EDE95585C142');
        $this->addSql('ALTER TABLE user_skill DROP FOREIGN KEY FK_BCFF1F2F5585C142');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4773FB1590C');
        $this->addSql('ALTER TABLE user_task DROP FOREIGN KEY FK_28FF97EC8DB60186');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11A76ED395');
        $this->addSql('ALTER TABLE recommendation DROP FOREIGN KEY FK_433224D2F624B39D');
        $this->addSql('ALTER TABLE recommendation DROP FOREIGN KEY FK_433224D2CD53EDB6');
        $this->addSql('ALTER TABLE user_language DROP FOREIGN KEY FK_345695B5A76ED395');
        $this->addSql('ALTER TABLE user_skill DROP FOREIGN KEY FK_BCFF1F2FA76ED395');
        $this->addSql('ALTER TABLE user_task DROP FOREIGN KEY FK_28FF97ECA76ED395');
        $this->addSql('ALTER TABLE user_accomplishment DROP FOREIGN KEY FK_C657C47AA76ED395');
        $this->addSql('DROP TABLE accomplishment');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_sdg');
        $this->addSql('DROP TABLE project_skill');
        $this->addSql('DROP TABLE recommendation');
        $this->addSql('DROP TABLE sdg');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skill_set');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_language');
        $this->addSql('DROP TABLE user_skill');
        $this->addSql('DROP TABLE user_task');
        $this->addSql('DROP TABLE user_accomplishment');
    }
}
