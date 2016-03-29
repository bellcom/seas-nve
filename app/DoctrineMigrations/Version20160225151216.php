<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160225151216 extends AbstractMigration {
  /**
   * @param Schema $schema
   */
  public function up(Schema $schema) {
    // this up() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('CREATE TABLE BelysningTiltagDetail_NytArmatur (id INT AUTO_INCREMENT NOT NULL, arbejde_omfang VARCHAR(255) NOT NULL, nyLyskildeAntal INT DEFAULT NULL, wattage INT DEFAULT NULL, nyeForkoblingerAntal INT DEFAULT NULL, pris NUMERIC(10, 4) DEFAULT NULL, noter VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    $this->addSql('ALTER TABLE TiltagDetail ADD NytArmatur_id INT DEFAULT NULL');
    $this->addSql('ALTER TABLE TiltagDetail ADD CONSTRAINT FK_C39D70CE8FB26026 FOREIGN KEY (NytArmatur_id) REFERENCES BelysningTiltagDetail_NytArmatur (id)');
    $this->addSql('CREATE INDEX IDX_C39D70CE8FB26026 ON TiltagDetail (NytArmatur_id)');
    $this->addSql('ALTER TABLE TiltagDetail_audit ADD NytArmatur_id INT DEFAULT NULL');

    $this->addSql("
      INSERT INTO BelysningTiltagDetail_NytArmatur (id, arbejde_omfang, nyLyskildeAntal, wattage, nyeForkoblingerAntal, pris, noter)
      VALUES
        (34,'B1-Påbygget aflangt LED belysningsarmatur 25W ',1,25,1,1680,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. påbyggede armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (35,'B2-Påbygget aflangt LED belysningsarmatur 25W med DALI',1,25,1,1780,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. påbyggede armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (36,'B3-Nedhængt aflangt LED linjebelysningsarmatur 25W',1,25,1,1975,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. nedhængte armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (37,'B4-Nedhængt aflangt LED linjebelysningsarmatur 25W med DALI',1,25,1,2175,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. nedhængte armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (38,'B5-Indbygget 600x600mm LED belysningsarmatur 32W ',1,32,1,1780,'inkl. demontering af eksist. armatur og lyskilde. Indbygget i 600x600mm lofter. '),
        (39,'B6-Påbygget 600x600mm LED belysningsarmatur 32W ',1,32,1,1980,'inkl. demontering af eksist. armatur og lyskilde. Påbygget i ramme. '),
        (40,'B7-Indbygget 600x600mm LED belysningsarmatur 32W med DALI ',1,32,1,1980,'inkl. demontering af eksist. armatur og lyskilde. Indbygget i 600x600mm lofter. '),
        (41,'B8-Påbygget 600x600mm LED belysningsarmatur 32W med DALI ',1,32,1,2180,''),
        (42,'B9-Påbygget aflangt LED belysningsarmatur med indbygget sensor for dagslys og PIR. 29W',1,29,1,2580,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. påbyggede armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (43,'B10-Nedhængt aflangt LED belysningsarmatur med indbygget sensor for dagslys og PIR. 29W',1,29,1,2875,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. nedhængte armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (44,'B11-Belysningsarmatur for væg eller loft, med indbygget sensor for dagslys og pir, kan kobles sammen med 16 stk trådløst. 20W',1,20,1,3475,'inkl. Demontering af eksist. Armatur og lyskilde.'),
        (45,'B12-Påbygget LED linjearmatur IP44 27W',1,27,1,1380,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. nedhængte armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (46,'B13a-Påbygget LED linjearmatur IP44 med HF sensor 27W',1,27,1,1880,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. nedhængte armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (47,'B13b-Påbygget LED linjearmatur, IP44 robust 21W.',1,21,1,1180,'inkl. demontering af eksist. armatur og lyskilde. Gælder - alm. nedhængte armaturer- Gennemfortrådet armaturer (synlige kabler føres mellem armaturerne)'),
        (48,'B14-Påbygnings LED belysningsarmaturer sportshaller 145W med DALI',1,145,1,4140,'Specialtilfælde kræver lysberegning. inkl. demontering af eksist. armatur og lyskilde. Ekskl. Leje af lift/stillads. '),
        (49,'B15-Påbygnings LED belysningsarmaturer rundt 14W',1,14,1,880,'inkl. demontering af eksist. armatur og lyskilde. '),
        (50,'B16-Påbygnings LED belysningsarmaturer rundt 14W med HF sensor',1,14,1,1080,'inkl. demontering af eksist. armatur og lyskilde. '),
        (51,'B17-Påbygnings LED belysningsarmaturer rundt 18W med DALI',1,18,1,1280,'inkl. demontering af eksist. armatur og lyskilde. '),
        (52,'B18-Påbygnings LED belysningsarmaturer rundt 18W',1,18,1,980,'inkl. demontering af eksist. armatur og lyskilde. '),
        (53,'B19-Påbygnings LED belysningsarmaturer rundt 18W med HF sensor',1,18,1,1480,'inkl. demontering af eksist. armatur og lyskilde. '),
        (54,'B20-Påbygnings LED belysningsarmaturer rundt 24W med DALI',1,24,1,2080,'inkl. demontering af eksist. armatur og lyskilde. '),
        (55,'B21-Påbygnings LED belysningsarmaturer rundt 24W',1,24,1,1880,'inkl. demontering af eksist. armatur og lyskilde. '),
        (56,'B22-Downlight ¯20 16W',1,16,1,1275,'inkl. demontering af eksist. armatur og lyskilde. '),
        (57,'B23-LED spejlarmatur 12W',1,12,1,885,'inkl. demontering af eksist. armatur og lyskilde. '),
        (58,'B24-LED spejlarmatur 12W med PIR sensor',1,12,1,1285,'inkl. demontering af eksist. armatur og lyskilde. Det er muligt at tilslutte ekstra belysningsarmatur til sensoren i spejlarmaturet'),
        (59,'B25-LED spejlarmatur 18W',1,18,1,985,'inkl. demontering af eksist. armatur og lyskilde. '),
        (60,'B26-LED spejlarmatur 18W med PIR sensor',1,18,1,1385,'inkl. demontering af eksist. armatur og lyskilde. Det er muligt at tilslutte ekstra belysningsarmatur til sensoren i spejlarmaturet'),
        (61,'B27-Udv. LED belysningsarmatur til væg 12W',1,12,1,3880,'inkl. demontering af eksist. armatur og lyskilde. '),
        (62,'B28-LED armatur til mastetop, opsættes på eksisterende master for parkarmaturer 25W',1,25,1,3880,'inkl. demontering af eksist. armatur og lyskilde, samt isætning af sikringselement'),
        (63,'B29-Floodlight LED projektør med sensor 20W',1,20,1,1490,'inkl. demontering af eksist. armatur og lyskilde. '),
        (64,'B30-Udv. LED belysningsarmatur til væg 10W',1,10,1,1380,'inkl. demontering af eksist. armatur og lyskilde.'),
        (65,'B31-Udv. LED belysningsarmatur til væg 10W med sensor',1,10,1,1680,'inkl. demontering af eksist. armatur og lyskilde.'),
        (66,'Andet, se noter',NULL,NULL,NULL,NULL,NULL)
    ");

  }

  /**
   * @param Schema $schema
   */
  public function down(Schema $schema) {
    // this down() migration is auto-generated, please modify it to your needs
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->addSql('ALTER TABLE TiltagDetail DROP FOREIGN KEY FK_C39D70CE8FB26026');
    $this->addSql('DROP TABLE BelysningTiltagDetail_NytArmatur');
    $this->addSql('DROP INDEX IDX_C39D70CE8FB26026 ON TiltagDetail');
    $this->addSql('ALTER TABLE TiltagDetail DROP NytArmatur_id');
    $this->addSql('ALTER TABLE TiltagDetail_audit DROP NytArmatur_id');
  }
}
