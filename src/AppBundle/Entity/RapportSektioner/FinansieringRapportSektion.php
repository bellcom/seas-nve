<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Calculation\Calculation;
use AppBundle\Form\Type\RapportSektion\FinansieringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * FinansieringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class FinansieringRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Finansiering';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new FinansieringRapportSektionType();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultableTextFields()
    {
        $textFields = parent::getDefaultableTextFields();
        $textFields[] = 'noegletal';
        $textFields[] = 'finansieringTekst';

        return $textFields;
    }

    /**
     * Gets nøgletaltekst.
     */
    public function getNoegletal() {
        return $this->getExtrasKeyValue('noegletal');
    }

    /**
     * Gets finansieringTekst.
     */
    public function getFinansieringTekst() {
        return $this->getExtrasKeyValue('finansieringTekst');
    }

    /**
     * Gets tekniskelevetid.
     */
    public function getTekniskelevetid() {
        return $this->getExtrasKeyValue('tekniskelevetid');
    }

    /**
     * Gets samletBesparelseOverAar.
     */
    public function getSamletBesparelseOverAar($years = 1) {
        return $this->getRapport()->getSamletEnergibesparelseKr() * $years;
    }

    public function getROIGrafData() {
        $nuvaerendeForbrugKr = $this->getRapport()->getForbrugFoerKr();
        $optimeretForbrugKr = $this->getRapport()->getForbrugEfterKr();
        $investering = $this->getRapport()->getAnlaegsinvestering();


        $roi = Calculation::divide($investering, $nuvaerendeForbrugKr - $optimeretForbrugKr);
        $years = [];
        foreach (array('start' => 0, 'end' => 30) as $key => $value) {
            $years[$key] = array(
                'year' => $value,
                'nuvaerende' => $nuvaerendeForbrugKr * $value,
                'optimeret' => $optimeretForbrugKr * $value + $investering,
            );
        }
        return array(
            'years' => $years,
            'investering' => $investering,
            'roi' => $roi,
        );
    }

}

