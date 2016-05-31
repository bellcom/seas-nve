<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160531140531 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX rev_db9e3c05f5f8081654fde657f5d341c9_idx ON Baseline_audit (rev)');
        $this->addSql('CREATE INDEX rev_270096beb63fb925ebfc0e94d992eddc_idx ON BaselineKorrektion_audit (rev)');
        $this->addSql('CREATE INDEX rev_e6206879acd1d12a0a350c572dc130a4_idx ON Tiltag_audit (rev)');
        $this->addSql('CREATE INDEX rev_71392465281ea0f430ff2adae9d79a7e_idx ON TiltagDetail_audit (rev)');
        $this->addSql('CREATE INDEX rev_afd26429ece1c217140462a2824ec5d8_idx ON Bilag_audit (rev)');
        $this->addSql('CREATE INDEX rev_8487774663fe10183bbf83fa12c6f622_idx ON Bygning_audit (rev)');
        $this->addSql('CREATE INDEX rev_01f9fd41f1c3d1e04ff074f09fb396f3_idx ON Configuration_audit (rev)');
        $this->addSql('CREATE INDEX rev_e458e6ed386fb34afcec6045ca5ae32e_idx ON InternProduktion_audit (rev)');
        $this->addSql('CREATE INDEX rev_b9b14ba4e2fbabc2b199bdaef2ab17ec_idx ON Energiforsyning_audit (rev)');
        $this->addSql('CREATE INDEX rev_0028638bb35a2e50efa960014d68b7a0_idx ON Forsyningsvaerk_audit (rev)');
        $this->addSql('CREATE INDEX rev_76a57d33058bcadf9aa11372def69eb0_idx ON Pumpe_audit (rev)');
        $this->addSql('CREATE INDEX rev_a2bb1af2892b306f2470aa165ada1a3f_idx ON Rapport_audit (rev)');
        $this->addSql('CREATE INDEX rev_9cb483a9f5884ae8fe5169fd1c86fcf0_idx ON Segment_audit (rev)');
        $this->addSql('CREATE INDEX rev_e40659eaa5d6cad720133c3595580717_idx ON Solcelle_audit (rev)');
        $this->addSql('CREATE INDEX rev_a962849b53219e0d3fa519108f9330c1_idx ON NyttiggjortVarme_audit (rev)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX rev_270096beb63fb925ebfc0e94d992eddc_idx ON BaselineKorrektion_audit');
        $this->addSql('DROP INDEX rev_db9e3c05f5f8081654fde657f5d341c9_idx ON Baseline_audit');
        $this->addSql('DROP INDEX rev_afd26429ece1c217140462a2824ec5d8_idx ON Bilag_audit');
        $this->addSql('DROP INDEX rev_8487774663fe10183bbf83fa12c6f622_idx ON Bygning_audit');
        $this->addSql('DROP INDEX rev_01f9fd41f1c3d1e04ff074f09fb396f3_idx ON Configuration_audit');
        $this->addSql('DROP INDEX rev_b9b14ba4e2fbabc2b199bdaef2ab17ec_idx ON Energiforsyning_audit');
        $this->addSql('DROP INDEX rev_0028638bb35a2e50efa960014d68b7a0_idx ON Forsyningsvaerk_audit');
        $this->addSql('DROP INDEX rev_e458e6ed386fb34afcec6045ca5ae32e_idx ON InternProduktion_audit');
        $this->addSql('DROP INDEX rev_a962849b53219e0d3fa519108f9330c1_idx ON NyttiggjortVarme_audit');
        $this->addSql('DROP INDEX rev_76a57d33058bcadf9aa11372def69eb0_idx ON Pumpe_audit');
        $this->addSql('DROP INDEX rev_a2bb1af2892b306f2470aa165ada1a3f_idx ON Rapport_audit');
        $this->addSql('DROP INDEX rev_9cb483a9f5884ae8fe5169fd1c86fcf0_idx ON Segment_audit');
        $this->addSql('DROP INDEX rev_e40659eaa5d6cad720133c3595580717_idx ON Solcelle_audit');
        $this->addSql('DROP INDEX rev_71392465281ea0f430ff2adae9d79a7e_idx ON TiltagDetail_audit');
        $this->addSql('DROP INDEX rev_e6206879acd1d12a0a350c572dc130a4_idx ON Tiltag_audit');
    }
}
