<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Calculation\Calculation;
use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use Doctrine\ORM\Mapping as ORM;

/**
 * OpsummeringRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class OpsummeringRapportSektion extends RapportSektion {

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->title = 'Opsummering';
        parent::__construct($params);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new OpsummeringRapportSektionType();
    }

    public function getAnbefalinger () {
        $anbefalinger = $this->getRapportSections()->filter(function ($section) { return $section->getType() == 'anbefaling'; });
        return array_values($anbefalinger->toArray());
    }

    public function getSeasAnbefalerUnderTekst () {
        return $this->getExtrasKeyValue('seasAnbefalerUnderTekst');
    }

    public function getSamletForbrugGrafData() {
        $rapport = $this->getRapport();
        $nuvaerendeForbrug = $rapport->getForbrugFoer();
        $optimeretForbrug = $rapport->getForbrugEfter();

        return array(
            'nuvaerende' =>$nuvaerendeForbrug,
            'optimeret' => $optimeretForbrug,
            'reduction' => round((1 - Calculation::divide($optimeretForbrug, $nuvaerendeForbrug)) * 100)
        );
    }

    public function getPotentieltBesparesleKwh() {
        return $this->getRapport()->getSamletEnergibesparelse();
    }

    public function getPotentieltBesparesleKr() {
        return $this->getRapport()->getSamletEnergibesparelseKr();
    }

    public function getPotentieltBesparesleCo2() {
        return $this->getRapport()->getForbrugFoerCo2() -  $this->getRapport()->getForbrugEfterCo2();
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

    /**
     * Defines allowed actions with SektionType.
     *
     * @return array
     */
    protected function allowedActions() {
        return array(
            self::ACTION_ADD,
            self::ACTION_DELETE
        );
    }

}

