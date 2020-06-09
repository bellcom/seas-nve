<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200520125836 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail DROP forkoblingStkArmatur, DROP elforbrugWM2, DROP styring, DROP nyForkoblingStkArmatur, DROP nyArmatureffektWStk, DROP nyttiggjortVarmeAfElBesparelse, DROP prisfaktorTillaegKrLokale, DROP nytElforbrugWM2, DROP driftsbesparelseTilLyskilderKrAar, DROP vaegtetLevetidAar, DROP kWhBesparelseVarmeFraVarmevaerket');
        $this->addSql('ALTER TABLE TiltagDetail_audit DROP forkoblingStkArmatur, DROP elforbrugWM2, DROP styring, DROP nyForkoblingStkArmatur, DROP nyArmatureffektWStk, DROP nyttiggjortVarmeAfElBesparelse, DROP prisfaktorTillaegKrLokale, DROP nytElforbrugWM2, DROP driftsbesparelseTilLyskilderKrAar, DROP vaegtetLevetidAar, DROP kWhBesparelseVarmeFraVarmevaerket');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD forkoblingStkArmatur INT DEFAULT NULL, ADD elforbrugWM2 DOUBLE PRECISION DEFAULT NULL, ADD styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:StyringType)\', ADD nyForkoblingStkArmatur INT DEFAULT NULL, ADD nyArmatureffektWStk DOUBLE PRECISION DEFAULT NULL, ADD nyttiggjortVarmeAfElBesparelse NUMERIC(10, 4) DEFAULT NULL, ADD prisfaktorTillaegKrLokale DOUBLE PRECISION DEFAULT NULL, ADD nytElforbrugWM2 DOUBLE PRECISION DEFAULT NULL, ADD driftsbesparelseTilLyskilderKrAar DOUBLE PRECISION DEFAULT NULL, ADD vaegtetLevetidAar DOUBLE PRECISION DEFAULT NULL, ADD kWhBesparelseVarmeFraVarmevaerket DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD forkoblingStkArmatur INT DEFAULT NULL, ADD elforbrugWM2 DOUBLE PRECISION DEFAULT NULL, ADD styring ENUM(\'\', \'S1\', \'S2\', \'S3\', \'S4\', \'S5\', \'S6\', \'S7\', \'S8\', \'S9\') DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:StyringType)\', ADD nyForkoblingStkArmatur INT DEFAULT NULL, ADD nyArmatureffektWStk DOUBLE PRECISION DEFAULT NULL, ADD nyttiggjortVarmeAfElBesparelse NUMERIC(10, 4) DEFAULT NULL, ADD prisfaktorTillaegKrLokale DOUBLE PRECISION DEFAULT NULL, ADD nytElforbrugWM2 DOUBLE PRECISION DEFAULT NULL, ADD driftsbesparelseTilLyskilderKrAar DOUBLE PRECISION DEFAULT NULL, ADD vaegtetLevetidAar DOUBLE PRECISION DEFAULT NULL, ADD kWhBesparelseVarmeFraVarmevaerket DOUBLE PRECISION DEFAULT NULL');
    }
}
