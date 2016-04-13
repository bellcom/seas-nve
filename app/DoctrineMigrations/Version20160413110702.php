<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160413110702 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline ADD elBaselineFastsatForEjendomKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeGAFForbrugKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeGUFForbrugKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeBaselineFastsatForEjendomKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeStrafafkoelingsafgiftKorrektion DOUBLE PRECISION DEFAULT NULL, ADD varmeStrafafkoelingsafgiftKorrigeret DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE Baseline_audit ADD elBaselineFastsatForEjendomKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeGAFForbrugKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeGUFForbrugKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeBaselineFastsatForEjendomKorrigeret DOUBLE PRECISION DEFAULT NULL, ADD varmeStrafafkoelingsafgiftKorrektion DOUBLE PRECISION DEFAULT NULL, ADD varmeStrafafkoelingsafgiftKorrigeret DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Baseline DROP elBaselineFastsatForEjendomKorrigeret, DROP varmeGAFForbrugKorrigeret, DROP varmeGUFForbrugKorrigeret, DROP varmeBaselineFastsatForEjendomKorrigeret, DROP varmeStrafafkoelingsafgiftKorrektion, DROP varmeStrafafkoelingsafgiftKorrigeret');
        $this->addSql('ALTER TABLE Baseline_audit DROP elBaselineFastsatForEjendomKorrigeret, DROP varmeGAFForbrugKorrigeret, DROP varmeGUFForbrugKorrigeret, DROP varmeBaselineFastsatForEjendomKorrigeret, DROP varmeStrafafkoelingsafgiftKorrektion, DROP varmeStrafafkoelingsafgiftKorrigeret');
    }
}
