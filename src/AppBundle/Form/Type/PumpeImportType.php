<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\FileImportType;

/**
 * Class PumpeImportType
 * @package AppBundle\Form
 */
class PumpeImportType extends FileImportType {
  public function getName() {
    return 'appbundle_pumpe_import';
  }
}
