<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\RapportSektion\ForsideRapportSektionType;
use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Uploadable\Mapping\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ForsideRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @Gedmo\Uploadable(
 *   path="uploads/images/rapport/forside/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true,
 *   allowedTypes="image/jpeg,image/pjpeg,image/png,image/x-png"
 * )
 */
class ForsideRapportSektion extends RapportSektion {

    use FilepathField;

    /**
     * Constructor
     */
    public function __construct($params) {
        parent::__construct($params);
        if (!empty($params['rapport_type'])) {
            switch($params['rapport_type']) {
                case VirksomhedRapport::RAPPORT_ENERGISYN:
                    $this->setTitle('Enegrisynsrapport');
                    break;

                case VirksomhedRapport::RAPPORT_SCREENING:
                    $this->setTitle('Screeningrapport');
                    break;

                case VirksomhedRapport::RAPPORT_DETAILARK:
                    $this->setTitle('Detailarkrapport');
                    break;
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getFormType() {
        return new ForsideRapportSektionType();
    }

    /**
     * Gets Virksomhed address.
     */
    public function getAddress() {
        if (!empty($this->getErstatningAdresse())) {
            return $this->getErstatningAdresse();
        }

        $rapport = $this->getRapport();
        return $rapport instanceof VirksomhedRapport ? $rapport->getVirksomhed()->getFullAddress() : '';
    }

    /**
     * Gets Virksomhed name.
     */
    public function getVirksomhedNavn() {
        $rapport = $this->getRapport();
        return $rapport instanceof VirksomhedRapport ? $rapport->getVirksomhed()->getName() : '';
    }

    /**
     * Gets Virksomhed datering.
     */
    public function getDatering() {
        return $this->getExtrasKeyValue('dato');
    }

    /**
     * @inheritDoc
     */
    public static function getExtrasDefault() {
        return array(
            'rapportTypeNavn' => 'Resultatoversigt',
            'skjuleKort' => FALSE,
            'erstatningAdresse' => '',
            'underTekst' => 'Undersagsnavn',
            'lovpligtTekst' => 'Lovpligtigt energisyn i henhold til Energistyrelsens bekendtgørelse nr. 1146 af 20-11-2019.',
        );
    }

    public function getRapportTypeNavn() { return $this->getExtrasKeyValue('rapportTypeNavn'); }
    public function getSkjuleKort() { return $this->getExtrasKeyValue('skjuleKort'); }
    public function getErstatningAdresse() { return $this->getExtrasKeyValue('erstatningAdresse'); }
    public function getUnderTekst() { return $this->getExtrasKeyValue('underTekst'); }
    public function getLovpligtTekst() { return $this->getExtrasKeyValue('lovpligtTekst'); }

    /**
     * {@inheritDoc}
     */
    public static function getDefaultableTextFields() {
        return array();
    }

    /**
     * {@inheritdoc }
     */
    public function init(ObjectManager $em) {
      parent::init($em);

      // Setting up default values if they not exist or have NULL as value.
      foreach(self::getExtrasDefault() as $key => $value) {
        if (!empty($value) && $this->getExtrasKeyValue($key) === NULL) {
          $this->extras[$key] = $value;
        }
      }
    }

    /**
     * {@inheritdoc }
     */
    public function setExtras($extras) {
        // Setting empty value as FALSE. To get ability save NON Null values.
        $extrasDefault = self::getExtrasDefault();
        foreach ($extrasDefault as $key => $value) {
          if (!isset($extras[$key]) && $value !== NULL) {
            $extras[$key] = FALSE;
          }
        }
        $this->extras = $extras;
        return $this;
    }

}

