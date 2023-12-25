<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231225132532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP description, DROP researcher_id');
        $this->addSql('ALTER TABLE publication ADD chercheur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779F0950B34 FOREIGN KEY (chercheur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779F0950B34 ON publication (chercheur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD description VARCHAR(255) NOT NULL, ADD researcher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779F0950B34');
        $this->addSql('DROP INDEX IDX_AF3C6779F0950B34 ON publication');
        $this->addSql('ALTER TABLE publication DROP chercheur_id');
    }
}
