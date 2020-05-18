<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200518140242 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag DROP risikovurdering, DROP risikovurderingTeknisk, DROP risikovurderingBrugsmoenster, DROP risikovurderingDatagrundlag, DROP risikovurderingDiverse, DROP risikovurderingAendringIBesparelseFaktor, DROP risikovurderingOekonomiskKompenseringIftInvesteringFaktor');
        $this->addSql('ALTER TABLE Tiltag_audit DROP risikovurdering, DROP risikovurderingTeknisk, DROP risikovurderingBrugsmoenster, DROP risikovurderingDatagrundlag, DROP risikovurderingDiverse, DROP risikovurderingAendringIBesparelseFaktor, DROP risikovurderingOekonomiskKompenseringIftInvesteringFaktor');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Tiltag ADD risikovurdering LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD risikovurderingTeknisk ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingBrugsmoenster ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDatagrundlag ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDiverse ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingAendringIBesparelseFaktor DOUBLE PRECISION DEFAULT NULL, ADD risikovurderingOekonomiskKompenseringIftInvesteringFaktor DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Tiltag_audit ADD risikovurdering LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, ADD risikovurderingTeknisk ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingBrugsmoenster ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDatagrundlag ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingDiverse ENUM(\'lav\', \'mellem\', \'hoej\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:RisikovurderingType)\', ADD risikovurderingAendringIBesparelseFaktor DOUBLE PRECISION DEFAULT NULL, ADD risikovurderingOekonomiskKompenseringIftInvesteringFaktor DOUBLE PRECISION DEFAULT NULL');
    }
}
