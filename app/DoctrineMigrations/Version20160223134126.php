<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160223134126 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD risikovurderingTeknisk ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingBrugsmoenster ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDatagrundlag ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDiverse ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingAendringIBesparelseFaktor NUMERIC(10, 0) DEFAULT NULL, ADD risikovurderingOekonomiskKompenseringIftInvesteringFaktor NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD risikovurderingTeknisk ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingBrugsmoenster ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDatagrundlag ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDiverse ENUM(\'\', \'lav\', \'mellem\', \'hoej\') DEFAULT NULL COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingAendringIBesparelseFaktor NUMERIC(10, 0) DEFAULT NULL, ADD risikovurderingOekonomiskKompenseringIftInvesteringFaktor NUMERIC(10, 0) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP risikovurderingTeknisk, DROP risikovurderingBrugsmoenster, DROP risikovurderingDatagrundlag, DROP risikovurderingDiverse, DROP risikovurderingAendringIBesparelseFaktor, DROP risikovurderingOekonomiskKompenseringIftInvesteringFaktor');
        $this->addSql('ALTER TABLE Tiltag_audit DROP risikovurderingTeknisk, DROP risikovurderingBrugsmoenster, DROP risikovurderingDatagrundlag, DROP risikovurderingDiverse, DROP risikovurderingAendringIBesparelseFaktor, DROP risikovurderingOekonomiskKompenseringIftInvesteringFaktor');
    }
}
