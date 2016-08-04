<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160503140211 extends AbstractMigration {
  /**
   * {@inheritdoc}
   */
  public function up(Schema $schema) {
    $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    $this->setDiscrValueOnAudited();
    $this->createMissingRevisions();
  }

  /**
   * Remedy bug in entity-audit-bundle where discr column value is not audited.
   */
  private function setDiscrValueOnAudited() {
    $sql = <<<SQL
update
  Tiltag_audit a
    join Tiltag t on a.id = t.id
set
  a.discr = t.discr;
SQL;
    $this->addSql($sql);

    $sql = <<<SQL
update
  TiltagDetail_audit a
    join TiltagDetail t on a.id = t.id
set
  a.discr = t.discr;
SQL;

    $this->addSql($sql);
  }

  /**
   * Create INS revisions for all entities that don't have it.
   */
  private function createMissingRevisions() {
    $sm = $this->connection->getSchemaManager();

    // The order here is important.
    // A table must come after tables it depends on.
    $auditTableNames = [
      'Configuration_audit',
      'Forsyningsvaerk_audit',
      'NyttiggjortVarme_audit',
      'Pumpe_audit',
      'Segment_audit',
      'Solcelle_audit',
      'Bygning_audit',
      'Rapport_audit',
      'Energiforsyning_audit',
      'InternProduktion_audit',
      'Bilag_audit',
      'Baseline_audit',
      'BaselineKorrektion_audit',
      'Tiltag_audit',
      'TiltagDetail_audit',
    ];

    $revisionOffset = 20000;

    $sql = [];

    // Move all existing revisions.
    $sql[] = <<<SQL
set @rev = 0
;

SQL;

    $sql[] = <<<SQL
update revisions set id = id + $revisionOffset where id < $revisionOffset
;

SQL;

    foreach ($auditTableNames as $auditTableName) {
      $this->write('<info>' . PHP_EOL . $auditTableName . PHP_EOL . '</info>');

      $tableName = preg_replace('/_audit$/', '', $auditTableName);

      // Create "INS" revision of all $tableName entities.
      $sql[] = <<<SQL
update $auditTableName set rev = rev + $revisionOffset
;

SQL;

      $columns = $sm->listTableColumns($tableName);

      $columnNames = array_map(function ($column) {
        return $column->getName();
      }, $columns);
      $columnNamesList = implode(', ', $columnNames);

      // Create audit entries for entities that don't have an INS action in
      // the audit table.
      // Use data from first row in audit table.
      // http://stackoverflow.com/a/14375121
      $sql[] = <<<SQL
insert into
  $auditTableName (rev, revtype, $columnNamesList)
select
  @rev := @rev + 1 as rev,
  'INS' revtype,
  $columnNamesList
from
  $auditTableName a inner join (
    select   id _id, revtype _revtype, min(rev) _min_rev
    from     $auditTableName
    group by _id
  ) b on a.id = b._id and a.rev = b._min_rev and b._revtype != 'INS'
;

SQL;

      // Create audit entries for entities that still don't have an INS action
      // in the audit table.
      // Use data from actual (current) entities.
      $sql[] = <<<SQL
insert into
  $auditTableName (rev, revtype, $columnNamesList)
select
  @rev := @rev + 1 as rev,
  'INS' revtype,
  $columnNamesList
from
  $tableName e
where
  id not in (select id from $auditTableName a where a.id = e.id and a.revtype = 'INS')
;

SQL;

      $sql[] = <<<SQL
insert into
  revisions (id, timestamp, username)
select
  rev, '1970-01-01', ''
from
  $auditTableName
where
  rev < $revisionOffset;
;

SQL;

      $sql[] = <<<SQL
alter table revisions auto_increment = 1;
SQL;
    }

    $this->addSql($sql);
  }

  /**
   * {@inheritdoc}
   */
  public function down(Schema $schema) {
  }

}
