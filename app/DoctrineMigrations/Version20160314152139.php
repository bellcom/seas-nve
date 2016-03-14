<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160314152139 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Add initial graddage data.
        $this->addSql("INSERT INTO GraddageFordeling (titel, januar, februar, marts, april, maj, juni, juli, august, september, oktober, november, december) VALUES
                      ('Normtal', 519.0, 486.0, 444.0, 311.0, 154.0, 58.0, 22.0, 18.0, 91.0, 207.0, 341.0, 461.0),
                      ('2006', 543.3, 458.9, 524.9, 309.2, 148.7, 40.7, 0.0, 6.6, 15.9, 124.5, 266.5, 301.5),
                      ('2007', 367.5, 411.7, 312.5, 212.9, 124.2, 27.8, 28.8, 23.2, 98.7, 235.1, 333.3, 394.4),
                      ('2008', 394.4, 343.7, 398.3, 261.6, 116.2, 43.5, 8.3, 9.6, 89.9, 207.2, 315.4, 421.4),
                      ('2009', 487.8, 447.4, 396.5, 200.4, 135.1, 114.0, 5.2, 4.8, 53.7, 266.4, 283.4, 465.7),
                      ('2010', 603.0, 510.6, 423.3, 304.8, 199.9, 58.4, 2.5, 22.8, 104.5, 252.1, 381.7, 626.3),
                      ('2011', 512.1, 472.2, 420.7, 181.9, 139.5, 29.8, 14.5, 23.3, 68.1, 205.6, 286.5, 378.7),
                      ('2012', 446.1, 482.4, 327.1, 290.4, 123.8, 87.0, 20.1, 7.7, 88.2, 242.0, 306.8, 496.5),
                      ('2013', 502.4, 471.1, 525.0, 300.3, 108.0, 35.3, 5.2, 5.7, 98.8, 163.8, 313.9, 360.4),
                      ('2014', 467.2, 356.6, 321.7, 217.6, 130.3, 37.2, 4.5, 37.8, 60.8, 143.0, 263.4, 421.5),
                      ('2015', 430.1, 414.1, 367.1, 262.1, 179.5, 78.3, 23.2, 2.7, 82.7, 211.9, 275.4, 314.3),
                      ('2016', 506,4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
                      ");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
