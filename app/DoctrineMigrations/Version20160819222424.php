<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160819222424 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD60177FDFF2E92');
        $this->addSql('DROP INDEX IDX_5CD60177FDFF2E92 ON cms_article');
        $this->addSql('ALTER TABLE cms_article ADD thumbnail_name VARCHAR(255) NOT NULL, DROP thumbnail_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_article ADD thumbnail_id INT DEFAULT NULL, DROP thumbnail_name');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD60177FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES cms_media (id)');
        $this->addSql('CREATE INDEX IDX_5CD60177FDFF2E92 ON cms_article (thumbnail_id)');
    }
}
