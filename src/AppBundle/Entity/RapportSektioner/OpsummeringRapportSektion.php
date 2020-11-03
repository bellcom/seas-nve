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

    public function getAnbefalinger () {
        $anbefalinger = $this->getRapportSections()->filter(function ($section) { return $section->getType() == 'anbefaling'; });
        return array_values($anbefalinger->toArray());
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
        return $this->getRapport()->getBesparelseCO2();
    }

    public function getROIGrafData() {
        $nuvaerendeForbrugKr = $this->getRapport()->getForbrugFoerKr();
        $optimeretForbrugKr = $this->getRapport()->getForbrugEfterKr();
        $investering = $this->getRapport()->getAnlaegsinvestering();


        $roi = Calculation::divide($investering, $nuvaerendeForbrugKr - $optimeretForbrugKr);
        $years = [];
        for ($i = 0; $i < 30; $i++) {
            $years[$i] = array(
                'year' => $i,
                'nuvaerende' => $nuvaerendeForbrugKr * $i,
                'optimeret' => $optimeretForbrugKr * $i + $investering,
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

