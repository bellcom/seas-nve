<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200420163846 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD energiTypeSekundaerFoer VARCHAR(255) DEFAULT NULL, ADD nyVarmeKildePrimaerAndel DOUBLE PRECISION DEFAULT NULL, ADD energiTypePrimaerEfter VARCHAR(255) DEFAULT NULL, ADD energiForbrugPrimaerEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD energiTypeSekundaerEfter VARCHAR(255) DEFAULT NULL, ADD energiForbrugSekundaerEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD forbrugFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD forbrugEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD forbrugBeregningKontrol LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE varmepumpeforbrug energiForbrugSekundaerFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD energiTypeSekundaerFoer VARCHAR(255) DEFAULT NULL, ADD nyVarmeKildePrimaerAndel DOUBLE PRECISION DEFAULT NULL, ADD energiTypePrimaerEfter VARCHAR(255) DEFAULT NULL, ADD energiForbrugPrimaerEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD energiTypeSekundaerEfter VARCHAR(255) DEFAULT NULL, ADD energiForbrugSekundaerEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD forbrugFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD forbrugEfter LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD forbrugBeregningKontrol LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE varmepumpeforbrug energiForbrugSekundaerFoer LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE TiltagDetail ADD varmePumpeForbrug LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', DROP energiTypeSekundaerFoer, DROP energiForbrugSekundaerFoer, DROP nyVarmeKildePrimaerAndel, DROP energiTypePrimaerEfter, DROP energiForbrugPrimaerEfter, DROP energiTypeSekundaerEfter, DROP energiForbrugSekundaerEfter, DROP forbrugFoer, DROP forbrugEfter, DROP forbrugBeregningKontrol');
        $this->addSql('ALTER TABLE TiltagDetail_audit ADD varmePumpeForbrug LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', DROP energiTypeSekundaerFoer, DROP energiForbrugSekundaerFoer, DROP nyVarmeKildePrimaerAndel, DROP energiTypePrimaerEfter, DROP energiForbrugPrimaerEfter, DROP energiTypeSekundaerEfter, DROP energiForbrugSekundaerEfter, DROP forbrugFoer, DROP forbrugEfter, DROP forbrugBeregningKontrol');
    }
}
