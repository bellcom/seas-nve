<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Form\Type\RapportSektion\FaktaOmVirksomedRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * FaktaOmVirksomhedRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class FaktaOmVirksomhedRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Fakta om virksomhed';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new FaktaOmVirksomedRapportSektionType();
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultableTextFields()
    {
        $textFields = parent::getDefaultableTextFields();
        $textFields[] = 'energiForbrugTekst';

        return $textFields;
    }

    public function getElForbrug () {
        return $this->getExtrasKeyValue('elForbrug');
    }

    public function getVarmeForbrug () {
        return $this->getExtrasKeyValue('varmeForbrug');
    }

    public function getBraendstofForbrug () {
        return $this->getExtrasKeyValue('braendstofForbrug');
    }

    public function getAfgifterForbrug () {
        return $this->getExtrasKeyValue('afgifterForbrug');
    }

    public function getCo2Forbrug () {
        return $this->getExtrasKeyValue('co2Forbrug');
    }

    public function getAnvendteTekst () {
        return $this->getExtrasKeyValue('anvendteTekst');
    }

    public function getAnvendteCo2Tekst () {
        return $this->getExtrasKeyValue('anvendteCo2Tekst');
    }

    public function getEnergiForbrugTekst () {
        return $this->getExtrasKeyValue('energiForbrugTekst');
    }

    public function getEnergiForbrugData () {
        $labels = $this->getRapport()->getBesparelseSlutanvendelserLabels();
        $chartData = array();
        $samletForbrug = $this->getEnergiForbrugSamlet();
        foreach ($this->getRapport()->getBesparelseSlutanvendelser() as $key => $value) {
            if (empty($value['forbrugFoer'])) {
                continue;
            }
            $chartData[] = array(
                'label' => $labels[$key] . ' ' . round($value['forbrugFoer'] / $samletForbrug * 100) . '%',
                'label_wihout_procent' => $labels[$key],
                'value' => $value['forbrugFoer'],
            );
        }
        return $chartData;
    }
    public function getEnergiForbrugSamlet () {
        $samletForbrug = 0;
        foreach ($this->getRapport()->getBesparelseSlutanvendelser() as $key => $value) {
            if (empty($value['forbrugFoer'])) {
                continue;
            }
            $samletForbrug += $value['forbrugFoer'];
        }
        return $samletForbrug;
    }

}

