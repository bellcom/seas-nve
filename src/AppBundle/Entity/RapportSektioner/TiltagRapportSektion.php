<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
use AppBundle\Entity\Tiltag;
use AppBundle\Form\Type\RapportSektion\OpsummeringRapportSektionType;
use AppBundle\Form\Type\RapportSektion\TiltagRapportSektionType;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
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
    public function __construct($defaults) {
        parent::__construct();
        if ($defaults['tiltag'] instanceof Tiltag) {
            $tiltag = $defaults['tiltag'];
            $this->setTiltag($tiltag);
            $this->setTiltagId($tiltag->getId());
        }    }

    /**
     * {@inheritdoc}
     */
    public function getFormType() {
        return new TiltagRapportSektionType();
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

