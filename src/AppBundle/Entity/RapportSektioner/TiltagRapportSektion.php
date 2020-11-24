<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Entity\ReportImage;
use AppBundle\Entity\ReportText;
use AppBundle\Entity\ReportTextRepository;
use AppBundle\Entity\Tiltag;
use AppBundle\Form\Type\RapportSektion\TiltagRapportSektionType;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Uploadable\Mapping\Validator;

/**
 * TiltagRapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\Uploadable(
 *   path="uploads/images/rapport/tiltag/",
 *   filenameGenerator=Validator::FILENAME_GENERATOR_ALPHANUMERIC,
 *   allowOverwrite=false,
 *   appendNumber=true,
 *   allowedTypes="image/jpeg,image/pjpeg,image/png,image/x-png"
 * )
 */
class TiltagRapportSektion extends RapportSektion implements SamletForbrugGrafDataInterface, ROIGrafDataInterface {

    use FilepathField;

    /**
     * @var Tiltag
     */
    protected $tiltag;

    /**
     * Constructor
     */
    public function __construct($params) {
        $this->extras = $this->getExtrasDefault();
        if ($params['tiltag'] instanceof Tiltag) {
            $tiltag = $params['tiltag'];
            $this->setTiltag($tiltag);
            $this->setTiltagId($tiltag->getId());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function init(ObjectManager $em) {
        // If entity field is NULL, use a default value.
        if ($this->getText() === NULL) {
            /** @var ReportText $defaultText */
            $defaultText = $em->getRepository('AppBundle:ReportText')->getDefaultText($this->getType(), $this->getTiltagType() . '_text');
            if ($defaultText) {
                $this->setText($defaultText->getBody());
            }
        }

        if (property_exists($this, 'filepath') && $this->getFilepath() == NULL) {
            /** @var ReportImage $defaultImage */
            if ($defaultImage = $em->getRepository('AppBundle:ReportImage')->getDefaultImage($this->getTiltagType())) {
                $this->setFilepathString($defaultImage->getFilepath());
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new TiltagRapportSektionType();
    }

    /**
     * Get section tiltag Type
     */
    public function getTiltagType() {
        return empty($this->getTiltag()) ? NULL :  array_search((new \ReflectionClass($this->getTiltag()))->getShortName(), Tiltag::getTypesConverted());
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultableTextFields()
    {
        $textFields = array();
        $tiltagTypes = Tiltag::getTypesConverted(TRUE);
        foreach ($tiltagTypes as $type) {
            if ($type == 'klimaskaerm') {
                continue;
            }
            $textFields[] = $type . '_text';
        }
        return $textFields;
    }

    /**
     * @inheritDoc
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function getSectionTitle() {
        return $this->title ?: $this->getTiltagTitle();
    }

    /**
     * Get tiltag title
     *
     * @return string
     */
    public function getTiltagTitle() {
        return empty($this->tiltag) ? '' : $this->tiltag->getTitle();
    }

    /**
     * @inheritDoc
     */
    public static function getExtrasDefault() {
        return array(
            'tiltagId' => NULL,
        );
    }

    public function getTiltagId() { return $this->getExtrasKeyValue('tiltagId'); }
    public function setTiltagId($tiltageId) { return $this->extras['tiltagId'] = $tiltageId; }

    /**
     * Get tiltag.
     *
     * @return Tiltag
     */
    public function getTiltag() {
        return $this->tiltag;
    }

    /**
     * Set tiltag.
     *
     * @return $this
     */
    public function setTiltag(Tiltag $tiltag) {
        $this->tiltag = $tiltag;
        return $this;
    }

    /**
     * Get tiltag section number.
     */
    public function getNumber() {
        $tiltagSections = $this->getRapportSections()->filter(function ($section) { return $section->getType() == 'tiltag'; });
        $number = 1;
        foreach ($tiltagSections as $key => $tiltagSection) {
            if ($tiltagSection->getId() == $this->getId()) {
                return $number;
            }
            $number++;
        }
        return NULL;
    }

    /**
     * Gets Besparelse effekt in kWh.
     *
     * @return float
     */
    public function getEffektBesparesleKwh() {
        return $this->getTiltag()->getForbrugFoer() - $this->getTiltag()->getForbrugEfter();
    }

    /**
     * Gets Besparelse effekt in kr.
     *
     * @return int
     */
    public function getEffektBesparesleKr() {
        return $this->getTiltag()->getSamletEnergibesparelse();
    }


    /**
     * Gets Besparelse effekt in tons CO2.
     *
     * @return float
     */
    public function getEffektBesparesleCo2() {
        return $this->getTiltag()->getSamletCo2besparelse();
    }

    /**
     * {@inheritDoc}
     */
    public function getTekniskelevetid() {
        return $this->getTiltag()->getLevetid();
    }

    /**
     * {@inheritDoc}
     */
    public function getSamletBesparelseOverAar($years = 1) {
        return $this->getTiltag()->getSamletEnergibesparelse() * $years;
    }

    /**
     * {@inheritDoc}
     */
    public function getNuvaerendeForbrug() {
        return $this->getTiltag()->getForbrugFoer();
    }

    /**
     * {@inheritDoc}
     */
    public function getOptimeretForbrug() {
        return $this->getTiltag()->getForbrugEfter();
    }

    /**
     * {@inheritDoc}
     */
    public function getOptimeretForbrugKr() {
        return $this->getTiltag()->getForbrugEfterKr();
    }

    /**
     * {@inheritDoc}
     */
    public function getNuvaerendeForbrugKr() {
        return $this->getTiltag()->getForbrugFoerKr();
    }

    /**
     * {@inheritDoc}
     */
    public function getInvestering() {
        return $this->getTiltag()->getAnlaegsinvestering();
    }

    /**
     * @inheritDoc
     */
    protected function nullDefaultableTextFields(EntityManagerInterface $em) {
        // Key for default value text depends on Tiltag type.
        /** @var ReportText $defaultText */
        $defaultText = $em->getRepository('AppBundle:ReportText')->getDefaultText($this->getType(), $this->getTiltagType() . '_text');
        if ($this->getText()) {
            if (strcmp($this->getText(), $defaultText->getBody()) == 0){
                $this->setText(NULL);
            }
        }

        if (property_exists($this, 'filepath') && $this->getFilepath()) {
            /** @var ReportImage $defaultImage */
            $defaultImage = $em->getRepository('AppBundle:ReportImage')->getDefaultImage($this->getTiltagType());
            if ($this->getFilepath() == $defaultImage->getFilepath()) {
                $this->setFilepath(NULL);
            }
        }

    }

    /**
     * Post load handler.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        /** @var EntityManagerInterface $em */
        $em = $event->getEntityManager();

        $tiltagRepository = $em->getRepository('AppBundle:Tiltag');
        $this->loadTiltag($tiltagRepository);
        parent::postLoad($event);
    }

    /**
     * Post persist handler.
     *
     * @ORM\PostPersist
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event) {
        $tiltagRepository = $event->getEntityManager()->getRepository('AppBundle:Tiltag');
        $this->loadTiltag($tiltagRepository);
        parent::prePersist($event);
    }

    protected function loadTiltag($tiltagRepository) {
        /** @var Tiltag $tiltag */
        if ($this->getTiltagId() && $tiltag = $tiltagRepository->find($this->getTiltagId())) {
            $this->setTiltag($tiltag);
        }
    }
}

