<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160518153700 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Set default values on existing data (cf. AppBundle\Entity\TiltagRepository::create($type)).

        $this->addSql("UPDATE Tiltag SET primaerEnterprise = 've' WHERE discr = 'solcelle' AND primaerEnterprise = ''");
        $this->addSql("UPDATE Tiltag SET kategori_id = (SELECT id FROM TiltagsKategori WHERE navn = 'Solceller') WHERE discr = 'solcelle' AND kategori_id IS NULL");

        $this->addSql("UPDATE Tiltag SET primaerEnterprise = 'vvs' WHERE discr = 'tekniskisolering' AND primaerEnterprise = ''");
        $this->addSql("UPDATE Tiltag SET kategori_id = (SELECT id FROM TiltagsKategori WHERE navn = 'Varmeanlæg - generelt') WHERE discr = 'tekniskisolering' AND kategori_id IS NULL");

        $this->addSql("UPDATE Tiltag SET primaerEnterprise = 'el' WHERE discr = 'belysning' AND primaerEnterprise = ''");
        $this->addSql("UPDATE Tiltag SET kategori_id = (SELECT id FROM TiltagsKategori WHERE navn = 'Belysning') WHERE discr = 'belysning' AND kategori_id IS NULL");

        $this->addSql("UPDATE Tiltag SET primaerEnterprise = 't/i' WHERE discr = 'klimaskærm' AND primaerEnterprise = ''");
        $this->addSql("UPDATE Tiltag SET kategori_id = (SELECT id FROM TiltagsKategori WHERE navn = 'Klimaskærm') WHERE discr = 'klimaskærm' AND kategori_id IS NULL");

        $this->addSql("UPDATE Tiltag SET primaerEnterprise = 'vvs' WHERE discr = 'pumpe' AND primaerEnterprise = ''");
        $this->addSql("UPDATE Tiltag SET kategori_id = (SELECT id FROM TiltagsKategori WHERE navn = 'Pumper') WHERE discr = 'pumpe' AND kategori_id IS NULL");

        $this->addSql("UPDATE Tiltag SET primaerEnterprise = 't' WHERE discr = 'vindue' AND primaerEnterprise = ''");
        $this->addSql("UPDATE Tiltag SET kategori_id = (SELECT id FROM TiltagsKategori WHERE navn = 'Vinduer, ovenlys, døre') WHERE discr = 'vindue' AND kategori_id IS NULL");
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
