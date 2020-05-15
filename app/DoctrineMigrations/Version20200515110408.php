<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200515110408 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('UPDATE TiltagDetail SET discr = "varmeanlaeg" WHERE TiltagDetail.discr = "varmepumpe"; ');
        $this->addSql('UPDATE Tiltag SET discr = "varmeanlaeg" WHERE Tiltag.discr = "varmepumpe"; ');
        $this->addSql('UPDATE TiltagDetail SET discr = "køleanlæg" WHERE TiltagDetail.discr = "koeling"; ');
        $this->addSql('UPDATE Tiltag SET discr = "køleanlæg" WHERE Tiltag.discr = "koeling"; ');
        $this->addSql('UPDATE Tiltag SET slutanvendelse = NULL WHERE Tiltag.slutanvendelse = ""; ');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
