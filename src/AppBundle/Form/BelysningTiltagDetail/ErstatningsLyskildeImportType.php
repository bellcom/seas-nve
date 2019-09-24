<?php

namespace AppBundle\Form\BelysningTiltagDetail;

use AppBundle\Form\FileImportType;

/**
 * Class ErstatningsLyskildeImportType
 * @package AppBundle\Form
 */
class ErstatningsLyskildeImportType extends FileImportType
{
    public function getName()
    {
        return 'appbundle_erstatningslyskilde_import';
    }
}
