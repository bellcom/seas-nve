<?php

namespace AppBundle\Form\BelysningTiltagDetail;

use AppBundle\Form\FileImportType;

/**
 * Class NytArmaturImportType
 * @package AppBundle\Form
 */
class NytArmaturImportType extends FileImportType
{
    public function getName()
    {
        return 'appbundle_nytArmatur_import';
    }
}
