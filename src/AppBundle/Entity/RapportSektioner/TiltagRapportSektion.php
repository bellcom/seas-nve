<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Entity\Tiltag;
use AppBundle\Form\Type\RapportSektion\TiltagRapportSektionType;
use Doctrine\ORM\EntityManager;
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
class TiltagRapportSektion extends RapportSektion {

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
            if ($params['entityManager'] instanceof EntityManager) {
                $em = $params['entityManager'];
                $rapportTextRepository = $em->getRepository('AppBundle:ReportText');
                $tiltagType = array_search((new \ReflectionClass($tiltag))->getShortName(), Tiltag::getTypesConverted());
                if ($reportText = $rapportTextRepository->getDefaultText('tiltag_' . $tiltagType . '_text')) {
                    $this->setText($reportText->getBody());
                }
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
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return !empty($this->tiltag) ? $this->tiltag->getTitle() : '';
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
     * Post load handler.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        $tiltagRepository = $event->getEntityManager()->getRepository('AppBundle:Tiltag');
        $this->loadTiltag($tiltagRepository);
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
    }

    protected function loadTiltag($tiltagRepository) {
        /** @var Tiltag $tiltag */
        if ($this->getTiltagId() && $tiltag = $tiltagRepository->find($this->getTiltagId())) {
            $this->setTiltag($tiltag);
        }
    }
}

