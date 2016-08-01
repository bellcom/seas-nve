<?php

namespace AppBundle\EntityAudit;

use Exception;
use SimpleThings\EntityAudit\AuditReader as BaseAuditReader;
use SimpleThings\EntityAudit\Exception\NoRevisionFoundException;
use Symfony\Component\Form\FormInterface;
use DateTime;

class AuditReader extends BaseAuditReader {
  protected $filter;

  public function setFilter(FormInterface $filter) {
    $this->filter = $filter;

    return $this;
  }

  protected function findWhere($className, $alias) {
    return $this->getWhereClause($className, $alias);
  }

  private function getWhereClause($className, $alias) {
    $where = '1=1';
    if ($this->filter) {
      switch ($className) {
        case 'AppBundle\Entity\Bygning':
          $fieldNames = ['navn', 'adresse', 'postnummer', 'status'];
          foreach ($fieldNames as $fieldName) {
            if ($this->filter->has($fieldName)) {
              $value = $this->filter->get($fieldName)->getNormData();
              if ($value) {
                $where .= ' AND ' . $fieldName . ' LIKE \'%' . self::mysqlEscape($value) . '%\'';
              }
            }
          }
          break;

        case 'AppBundle\Entity\Rapport':
          if ($this->filter->has('rapport')) {
            $filter = $this->filter->get('rapport');
            $fieldName = 'datering';
            if ($filter->has($fieldName)) {
              $value = $filter->get($fieldName)->getNormData();
              if ($value) {
                $where .= ' AND ' . $fieldName . ' BETWEEN ' . self::mysqlEscape($value['left_date'] ? $value['left_date']->format('Y-m-d') : '1900-01-01', TRUE) . ' AND ' . self::mysqlEscape($value['right_date'] ? $value['right_date']->format('Y-m-d') : '2100-01-01', TRUE);
              }
            }
          }
          break;

        case 'AppBundle\Entity\Segment':
          $fieldName = 'forkortelse';
          if ($this->filter->has($fieldName)) {
            $value = $this->filter->get($fieldName)->getNormData();
            if ($value) {
              $where .= ' AND ' . $fieldName . ' LIKE \'%' . self::mysqlEscape($value) . '%\'';
            }
          }
          break;

      }
    }

    return $where;
  }

  private static function mysqlEscape($value, $quote = FALSE) {
    $value = str_replace("'", "\\'", $value);
    return $quote ? "'" . $value . "'" : $value;
  }

  /**
   * Get entities at a specified point in time.
   */
  public function getEntitiesAtTime($className, DateTime $timestamp) {
    $entities = [];

    $revisions = $this->getEntityRevisions($className, $timestamp);

    foreach ($revisions as $revision) {
      try {
        $entities[] = $this->find($className, $revision['id'], $revision['rev'], [ 'exactRevision' => true ]);
      } catch (NoRevisionFoundException $ex) {
      } catch (Exception $ex) {
        throw $ex;
      }
    }

    return $entities;
  }

  /**
   * Get entity id and the lastest revision before a given time.
   */
  private function getEntityRevisions($className, DateTime $timestamp) {
    $tableName = NULL;

    switch ($className) {
      case 'AppBundle\Entity\Bygning':
        $tableName = 'Bygning';
        break;
    }

    // $metadata = new \Doctrine\ORM\Mapping\ClassMetadataInfo($className);
    // $tableName = $metadata->getTableName();

    $auditTableName = $tableName . '_audit';

    $sql = <<<SQL
select
  e.id, max(e.rev) rev
from
  $auditTableName e
		inner join revisions r on e.rev = r.id
where
	r.timestamp <= :timestamp
    and e.revtype != 'DEL'
group by
  e.id
;
SQL;

    $stmt = $this->getConnection()->prepare($sql);
    $stmt->bindValue('timestamp', $timestamp->format('c'));
    $result = $stmt->execute();
    $rows = $stmt->fetchAll();

    return array_map(function($row) {
      return [ 'id' => $row['id'], 'rev' => $row['rev'] ];
    }, $rows);
  }

}
