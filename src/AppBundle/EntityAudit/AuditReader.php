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
          $fieldName = 'navn';
          if ($this->filter->has($fieldName)) {
            $value = $this->filter->get($fieldName)->getNormData();
            if ($value) {
              $where .= ' AND ' . $fieldName . ' LIKE \'%' . self::mysqlEscape($value) . '%\'';
            }
          }

          $fieldName = 'postnummer';
          if ($this->filter->has($fieldName)) {
            $value = $this->filter->get($fieldName)->getNormData();
            if ($value) {
              $where .= ' AND ' . $fieldName . ' LIKE \'%' . self::mysqlEscape($value) . '%\'';
            }
          }

          $fieldName = 'status';
          if ($this->filter->has($fieldName)) {
            $value = $this->filter->get($fieldName)->getNormData();
            if ($value) {
              $where .= ' AND ' . $fieldName . ' LIKE \'%' . self::mysqlEscape($value) . '%\'';
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

    $revision = $this->getRevisionByDate($timestamp);
    $ids = $this->getEntityIds($className, $timestamp);

    foreach ($ids as $id) {
      try {
        $entities[] = $this->find($className, $id, $revision);
      } catch (NoRevisionFoundException $ex) {
      } catch (Exception $ex) {
        throw $ex;
      }
    }

    return $entities;
  }

  /**
   *
   */
  private function getEntityIds($className, DateTime $timestamp) {
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
select distinct
  e.id
from
  $auditTableName e
		inner join revisions r on e.rev = r.id
where
	r.timestamp <= :timestamp
    and e.revtype != 'DEL'
;
SQL;

    $stmt = $this->getConnection()->prepare($sql);
    $stmt->bindValue('timestamp', $timestamp->format('c'));
    $result = $stmt->execute();
    $rows = $stmt->fetchAll();

    return array_map(function($row) {
      return $row['id'];
    }, $rows);
  }

  // @see https://github.com/simplethings/EntityAudit/pull/177/files
  public function getRevisionByDate(\DateTime $date) {
    $revision = null;

    $query = "SELECT revisions.id FROM "
           .'revisions'
           ." WHERE timestamp <= '".$date->format("Y-m-d H:i:s")."' ORDER BY revisions.timestamp DESC,revisions.id DESC LIMIT 1";

    $row = $this->getConnection()->fetchAssoc($query);

    if ($row) {
      $revision = $row['id'];
    }

    return $revision;
  }

}
