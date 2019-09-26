<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\FileImportType;

/**
 * Class KlimaskaermImportType
 * @package AppBundle\Form
 */
class KlimaskaermImportType extends FileImportType {
  public function getName() {
    return 'appbundle_klimaskaerm_import';
  }
}
