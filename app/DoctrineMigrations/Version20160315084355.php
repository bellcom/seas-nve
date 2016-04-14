<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160315084355 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ELOFordeling CHANGE januar januar DOUBLE PRECISION DEFAULT NULL, CHANGE februar februar DOUBLE PRECISION DEFAULT NULL, CHANGE marts marts DOUBLE PRECISION DEFAULT NULL, CHANGE april april DOUBLE PRECISION DEFAULT NULL, CHANGE maj maj DOUBLE PRECISION DEFAULT NULL, CHANGE juni juni DOUBLE PRECISION DEFAULT NULL, CHANGE juli juli DOUBLE PRECISION DEFAULT NULL, CHANGE august august DOUBLE PRECISION DEFAULT NULL, CHANGE september september DOUBLE PRECISION DEFAULT NULL, CHANGE oktober oktober DOUBLE PRECISION DEFAULT NULL, CHANGE november november DOUBLE PRECISION DEFAULT NULL, CHANGE december december DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE GraddageFordeling CHANGE januar januar DOUBLE PRECISION DEFAULT NULL, CHANGE februar februar DOUBLE PRECISION DEFAULT NULL, CHANGE marts marts DOUBLE PRECISION DEFAULT NULL, CHANGE april april DOUBLE PRECISION DEFAULT NULL, CHANGE maj maj DOUBLE PRECISION DEFAULT NULL, CHANGE juni juni DOUBLE PRECISION DEFAULT NULL, CHANGE juli juli DOUBLE PRECISION DEFAULT NULL, CHANGE august august DOUBLE PRECISION DEFAULT NULL, CHANGE september september DOUBLE PRECISION DEFAULT NULL, CHANGE oktober oktober DOUBLE PRECISION DEFAULT NULL, CHANGE november november DOUBLE PRECISION DEFAULT NULL, CHANGE december december DOUBLE PRECISION DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ELOFordeling CHANGE januar januar DOUBLE PRECISION NOT NULL, CHANGE februar februar DOUBLE PRECISION NOT NULL, CHANGE marts marts DOUBLE PRECISION NOT NULL, CHANGE april april DOUBLE PRECISION NOT NULL, CHANGE maj maj DOUBLE PRECISION NOT NULL, CHANGE juni juni DOUBLE PRECISION NOT NULL, CHANGE juli juli DOUBLE PRECISION NOT NULL, CHANGE august august DOUBLE PRECISION NOT NULL, CHANGE september september DOUBLE PRECISION NOT NULL, CHANGE oktober oktober DOUBLE PRECISION NOT NULL, CHANGE november november DOUBLE PRECISION NOT NULL, CHANGE december december DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE GraddageFordeling CHANGE januar januar DOUBLE PRECISION NOT NULL, CHANGE februar februar DOUBLE PRECISION NOT NULL, CHANGE marts marts DOUBLE PRECISION NOT NULL, CHANGE april april DOUBLE PRECISION NOT NULL, CHANGE maj maj DOUBLE PRECISION NOT NULL, CHANGE juni juni DOUBLE PRECISION NOT NULL, CHANGE juli juli DOUBLE PRECISION NOT NULL, CHANGE august august DOUBLE PRECISION NOT NULL, CHANGE september september DOUBLE PRECISION NOT NULL, CHANGE oktober oktober DOUBLE PRECISION NOT NULL, CHANGE november november DOUBLE PRECISION NOT NULL, CHANGE december december DOUBLE PRECISION NOT NULL');
    }
}
