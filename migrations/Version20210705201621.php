<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210705201621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tchat ADD project_id INT NOT NULL');
        $this->addSql('ALTER TABLE tchat ADD CONSTRAINT FK_8EA99CA4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8EA99CA4166D1F9C ON tchat (project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tchat DROP FOREIGN KEY FK_8EA99CA4166D1F9C');
        $this->addSql('DROP INDEX UNIQ_8EA99CA4166D1F9C ON tchat');
        $this->addSql('ALTER TABLE tchat DROP project_id');
    }
}
