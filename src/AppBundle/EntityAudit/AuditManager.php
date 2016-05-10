<?php

namespace AppBundle\EntityAudit;

use SimpleThings\EntityAudit\AuditManager as BaseAuditManager;
use Doctrine\ORM\EntityManager;

class AuditManager extends BaseAuditManager {
  public function createAuditReader(EntityManager $em) {
    return new AuditReader($em, $this->getConfiguration(), $this->getMetadataFactory());
  }
}
