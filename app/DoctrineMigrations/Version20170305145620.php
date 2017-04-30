<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170305145620 extends AbstractMigration
{
    /**
     * Make each authorName unique from table fbn_user before creating unique index.
     *
     * @param Schema $schema
     */
    public function preUp(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $sql = 'SELECT id,authorName FROM fbn_user';
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        while ($fetch = $stmt->fetch()) {
            $authorName = $fetch['authorName'].'-'.$fetch['id'];
            $this->connection->executeUpdate('UPDATE fbn_user SET authorName = ? WHERE id = ?', array($authorName, $fetch['id']));
        }
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_4BE514FC523D1C4E ON fbn_user (authorName)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_4BE514FC523D1C4E ON fbn_user');
    }
}
