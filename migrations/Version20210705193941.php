<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705193941 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tchat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tchat_user (tchat_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D12E1232CACEEE58 (tchat_id), INDEX IDX_D12E1232A76ED395 (user_id), PRIMARY KEY(tchat_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tchat_message (id INT AUTO_INCREMENT NOT NULL, speaker_id INT NOT NULL, tchat_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_F45F6AE9D04A0F27 (speaker_id), INDEX IDX_F45F6AE9CACEEE58 (tchat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tchat_user ADD CONSTRAINT FK_D12E1232CACEEE58 FOREIGN KEY (tchat_id) REFERENCES tchat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tchat_user ADD CONSTRAINT FK_D12E1232A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tchat_message ADD CONSTRAINT FK_F45F6AE9D04A0F27 FOREIGN KEY (speaker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tchat_message ADD CONSTRAINT FK_F45F6AE9CACEEE58 FOREIGN KEY (tchat_id) REFERENCES tchat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tchat_user DROP FOREIGN KEY FK_D12E1232CACEEE58');
        $this->addSql('ALTER TABLE tchat_message DROP FOREIGN KEY FK_F45F6AE9CACEEE58');
        $this->addSql('DROP TABLE tchat');
        $this->addSql('DROP TABLE tchat_user');
        $this->addSql('DROP TABLE tchat_message');
    }
}
