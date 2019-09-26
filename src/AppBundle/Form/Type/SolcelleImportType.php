<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\FileImportType;

/**
 * Class SolcelleImportType
 * @package AppBundle\Form
 */
class SolcelleImportType extends FileImportType {
  public function getName() {
    return 'appbundle_solcelle_import';
  }
}
