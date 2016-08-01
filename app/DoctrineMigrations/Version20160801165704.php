<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Add the social urls fields to the Partner table, change the baseline column to nullable
 */
class Version20160801165704 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecomptoir_partner ADD twitter LONGTEXT DEFAULT NULL, ADD facebook LONGTEXT DEFAULT NULL, ADD instagram LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE lecomptoir_partner CHANGE baseline baseline VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecomptoir_partner DROP twitter, DROP facebook, DROP instagram');
        $this->addSql('ALTER TABLE lecomptoir_partner CHANGE baseline baseline VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
