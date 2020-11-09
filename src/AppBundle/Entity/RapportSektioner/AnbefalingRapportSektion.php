<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Calculation\Calculation;
use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Entity\User;
use AppBundle\Form\Type\RapportSektion\AnbefalingRapportSektionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Uploadable\Mapping\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AnbefalingRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Uploadable(
 *   path="uploads/images/rapport/anbefaling/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true,
 *   allowedTypes="image/jpeg,image/pjpeg,image/png,image/x-png"
 * )
 */
class AnbefalingRapportSektion extends RapportSektion {

    use FilepathField;

    /**
     * Get anbefaling title for rendering.
     */
    public function getAnbefalingTitle() {
        if (empty($this->title) && $this->getAnbefalingType()) {
            return $this->getAnbefalingTypeLabel();
        }
        return $this->title;
    }

    /**
     * Get anbefaling number.
     */
    public function getNumber() {
        $anbefalinger = $this->getRapportSections()->filter(function ($section) { return $section->getType() == 'anbefaling'; });
        $number = 1;
        foreach ($anbefalinger as $key => $anbefaling) {
            if ($anbefaling == $this) {
                return $number;
            }
            $number++;
        }
        return NULL;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new AnbefalingRapportSektionType();
    }

    public function getAnbefalingType() {
        return $this->getExtrasKeyValue('type');
    }

    public function getAnbefalingTypeLabel() {
        $types = SlutanvendelseType::getChoices();
        return isset($types[$this->getAnbefalingType()]) ? $types[$this->getAnbefalingType()] : '';
    }

    /**
     * Get value from rapport Slutanvendelse array
     *
     * @param $key
     * @return float|null
     */
    public function getSluanvendelseValue($key) {
        $slutanvendelser = $this->getRapport()->getBesparelseSlutanvendelser();
        return isset($slutanvendelser[$this->getAnbefalingType()][$key]) ? $slutanvendelser[$this->getAnbefalingType()][$key] : NULL;
    }

    public function getPotentieltBesparesleKwh() {
        return $this->getSluanvendelseValue('total');
    }

    public function getPotentieltBesparesleKr() {
        return $this->getSluanvendelseValue('totalKr');
    }

    public function getPotentieltBesparesleCo2() {
        return $this->getSluanvendelseValue('totalCo2');
    }

    public function getTidsforloebUger() {
        return $this->getExtrasKeyValue('tidsforloebuger');
    }

    public function getPris() {
        return $this->getExtrasKeyValue('pris');
    }

    public function getRessourcertekst() {
        return $this->getExtrasKeyValue('ressourcertekst');
    }

    /**
     * Gets Simplel tilbagbetalingstid (ROI)
     *
     * @return string
     */
    public function getROI() {
        return Calculation::divide($this->getSluanvendelseValue('investering'), $this->getSluanvendelseValue('totalKr'));
    }

    /**
     * Gets raddgiver
     *
     * @return User|null
     */
    public function getRaadgiver() {
        return $this->getExtrasKeyValue('raadgiver');
    }

    /**
     * Gets raddgiver name
     *
     * @return string
     */
    public function getRaadgiversName() {
        /** @var User $raadgiver */
        $raadgiver = $this->getExtrasKeyValue('raadgiver');
        return $raadgiver ? $raadgiver->getFullname() : NULL;
    }

    /**
     * Gets raddgiver phone
     *
     * @return string
     */
    public function getTelephone() {
        $telefon = $this->getExtrasKeyValue('telefon');
        if ($telefon) {
            return $telefon;
        }
        /** @var User $raadgiver */
        $raadgiver = $this->getExtrasKeyValue('raadgiver');
        return $raadgiver ? $raadgiver->getPhone() : NULL;
    }

    public function getROIGrafData() {
        $nuvaerendeForbrugKr = $this->getSluanvendelseValue('forbrugFoerKr');
        $optimeretForbrugKr = $this->getSluanvendelseValue('forbrugEfterKr');
        $investering = $this->getSluanvendelseValue('investering');

        $roi = $this->getROI();
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

    public function getTidlsforloebInfo() {
        return $this->getExtrasKeyValue('tidsforloebinfo');
    }

    public function getTidlsforloebData() {
        $tidsforloebinfo = $this->getTidlsforloebInfo();
        $data = array();
        $start = empty($tidsforloebinfo) ? NULL : reset($tidsforloebinfo);
        $end = empty($tidsforloebinfo) ? NULL : end($tidsforloebinfo);
        if (empty($start['startuge']) || empty($end['slutuge'])) {
            return $data;
        }
        if ($start['startuge'] > $start['slutuge']) {
            $start['startuge'] = $start['startuge'] - 52;
        }
        for ($i = $start['startuge']; $i <= $end['slutuge']; $i++) {
            if ($i + 1 > 52 ) {
                $i = 1;
            }
            $column = array(
                'week_num' => $i,
                'label' =>'Uge ' . $i,
                'rows' => array(),
            );

            foreach ($tidsforloebinfo as $key => $rowInfo) {
                if (array_filter($rowInfo) != $rowInfo) {
                    continue;
                }
                if ($rowInfo['startuge'] > $rowInfo['slutuge']) {
                    $rowInfo['startuge'] = $rowInfo['startuge'] - 52;
                }
                if ($rowInfo['startuge'] <= $i && $i <= $rowInfo['slutuge']) {
                    $column['rows'][$key] = TRUE;
                }
            }
            $data[] = $column;
        }
        return $data;
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

    /**
     * {@inheritDoc}
     */
    public function postLoad(LifecycleEventArgs $event) {
        parent::postLoad($event);
        /** @var EntityManagerInterface $em */
        $em = $event->getEntityManager();
        /** @var User $raadgiver */
        $raadgiver = $this->getExtrasKeyValue('raadgiver');
        if (!empty($raadgiver)) {
            $this->extras['raadgiver'] = $em->getRepository('AppBundle:User')->find($raadgiver->getId());
        }
    }

}

