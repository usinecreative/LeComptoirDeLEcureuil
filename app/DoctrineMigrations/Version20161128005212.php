<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Change Media table due to new entity.
 */
class Version20161128005212 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_media ADD updatedAt DATETIME NOT NULL, DROP updated_at, CHANGE filepath fileType VARCHAR(255) NOT NULL, CHANGE created_at createdAt DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cms_media ADD description LONGTEXT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_media ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP createdAt, DROP updatedAt, CHANGE filetype filepath VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE cms_media DROP description');
    }
}
