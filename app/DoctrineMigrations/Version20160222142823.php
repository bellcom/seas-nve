<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160222142823 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Forsyningsvaerk ADD pris2009 NUMERIC(10, 4) DEFAULT NULL, ADD pris2010 NUMERIC(10, 4) DEFAULT NULL, ADD pris2011 NUMERIC(10, 4) DEFAULT NULL, ADD pris2012 NUMERIC(10, 4) DEFAULT NULL, ADD pris2013 NUMERIC(10, 4) DEFAULT NULL, ADD pris2014 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2009 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2010 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2011 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2012 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2013 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2014 NUMERIC(10, 4) DEFAULT NULL');
        $this->addSql('ALTER TABLE Forsyningsvaerk_audit ADD pris2009 NUMERIC(10, 4) DEFAULT NULL, ADD pris2010 NUMERIC(10, 4) DEFAULT NULL, ADD pris2011 NUMERIC(10, 4) DEFAULT NULL, ADD pris2012 NUMERIC(10, 4) DEFAULT NULL, ADD pris2013 NUMERIC(10, 4) DEFAULT NULL, ADD pris2014 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2009 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2010 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2011 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2012 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2013 NUMERIC(10, 4) DEFAULT NULL, ADD co2y2014 NUMERIC(10, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Forsyningsvaerk DROP pris2009, DROP pris2010, DROP pris2011, DROP pris2012, DROP pris2013, DROP pris2014, DROP co2y2009, DROP co2y2010, DROP co2y2011, DROP co2y2012, DROP co2y2013, DROP co2y2014');
        $this->addSql('ALTER TABLE Forsyningsvaerk_audit DROP pris2009, DROP pris2010, DROP pris2011, DROP pris2012, DROP pris2013, DROP pris2014, DROP co2y2009, DROP co2y2010, DROP co2y2011, DROP co2y2012, DROP co2y2013, DROP co2y2014');
    }
}
