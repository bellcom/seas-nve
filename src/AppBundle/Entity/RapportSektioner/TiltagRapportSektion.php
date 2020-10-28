<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\RapportSektioner\Traits\FilepathField;
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
        }
    }

    /**
     * {@inheritdoc}
     */
    public function init(ObjectManager $em) {
        // Fill in defaultable values (using default texts).
        $defaultableTextFields = $this::getDefaultableTextFields();

        foreach ($defaultableTextFields as $field) {
            // Checking if it is an extra field.
            $isExtraField = !property_exists($this, $field);

            $fieldValue = $isExtraField ? $this->getExtrasKeyValue($field) : $this->{$field};

            // If entity field is NULL, use a default value.
            if ($fieldValue === NULL) {
                /** @var ReportTextRepository $textRepository */
                $textRepository = $em->getRepository('AppBundle:ReportText');

                $tiltagType = array_search((new \ReflectionClass($this->getTiltag()))->getShortName(), Tiltag::getTypesConverted());
                $tiltagSectionType = $this->getType() . '_' . $tiltagType;

                /** @var ReportText $defaultText */
                $defaultText = $textRepository->getDefaultText($tiltagSectionType, $field);
                if ($defaultText) {
                    if ($isExtraField) {
                        $this->setExtrasKeyValue($field, $defaultText->getBody());
                    }
                    else {
                        $this->{$field} = $defaultText->getBody();
                    }
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
    }

    protected function loadTiltag($tiltagRepository) {
        /** @var Tiltag $tiltag */
        if ($this->getTiltagId() && $tiltag = $tiltagRepository->find($this->getTiltagId())) {
            $this->setTiltag($tiltag);
        }
    }
}

