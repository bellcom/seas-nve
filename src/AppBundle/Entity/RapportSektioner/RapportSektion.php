<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\ReportText;
use AppBundle\Entity\ReportTextRepository;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\RapportSektion\RapportSektionType;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Component\Form\FormTypeInterface;

/**
 * RapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RapportSektioner\RapportSektionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *    "tiltag" = "TiltagRapportSektion",
 *    "forside" = "ForsideRapportSektion",
 *    "kontaktinformation" = "KontaktInformationRapportSektion",
 *    "opsummering" = "OpsummeringRapportSektion",
 *    "anbefaling" = "AnbefalingRapportSektion",
 *    "faktavirksomhed" = "FaktaOmVirksomhedRapportSektion",
 *    "finansiering" = "FinansieringRapportSektion",
 *    "baeredygtighed" = "BaeredygtighedRapportSektion"
 * })
 */
abstract class RapportSektion
{
    const ACTION_ADD = 'add';
    const ACTION_DELETE = 'delete';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var array
     *
     * @ORM\Column(name="extras", type="array")
     */
    protected $extras;

    /**
     * Flag that defines section to be rendered landscape orientation.
     */
    public $landscape = false;

    /**
     * Flag that defines section to be rendered on new page.
     */
    public $break = true;

    /**
     * Edit Url defines in runtime before rendering.
     */
    public $editUrl;

    /**
     * Rapport oversigt section reference to Bygning rapport
     *
     * @var Rapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rapport", inversedBy="rapportOversigtSektioner")
     * @ORM\JoinColumn(name="bygning_oversigt_rapport_id", referencedColumnName="id")
     */
    protected $bygningOversigtRapport;

    /**
     * Rapport oversigt section reference to Virksomhed rapport
     *
     * @var VirksomhedRapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VirksomhedRapport", inversedBy="rapportOversigtSektioner")
     * @ORM\JoinColumn(name="virksomhed_oversigt_rapport_id", referencedColumnName="id")
     */
    protected $virksomhedOversigtRapport;

    /**
     * Constructor
     *
     * @param array $params
     */
    public function __construct($params = array()) {
        $this->extras = $this->getExtrasDefault();
    }

    /**
     * Does the initilization of RapportSektion.
     *
     * Fills the entity with the default values.
     *
     * @param ObjectManager $em
     *   Entity manager.
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

                /** @var ReportText $defaultText */
                $defaultText = $textRepository->getDefaultText($this->getType(), $field);
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
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return RapportSektion
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return RapportSektion
     */
    public function setText($text) {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set extras
     *
     * @param array $extras
     *
     * @return RapportSektion
     */
    public function setExtras($extras) {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Get extras
     *
     * @return array
     */
    public function getExtras() {
        return $this->extras;
    }

    /**
     * Set bygningOversigtRapport
     *
     * @param \AppBundle\Entity\Rapport $bygningOversigtRapport
     * @return RapportSektion
     */
    public function setByningOversigtRapport(Rapport $bygningOversigtRapport = NULL) {
        $this->bygningOversigtRapport = $bygningOversigtRapport;

        return $this;
    }

    /**
     * Get bygningOversigtRapport
     *
     * @return \AppBundle\Entity\Rapport
     */
    public function getBygningOversigtRapport() {
        return $this->bygningOversigtRapport;
    }

    /**
     * Set virksomhedOversigtRapport
     *
     * @param \AppBundle\Entity\VirksomhedRapport $virksomhedOversigtRapport
     * @return RapportSektion
     */
    public function setVirksomhedOversigtRapport(VirksomhedRapport $virksomhedOversigtRapport = NULL) {
        $this->virksomhedOversigtRapport = $virksomhedOversigtRapport;

        return $this;
    }

    /**
     * Get virksomhedOversigtRapport
     *
     * @return \AppBundle\Entity\VirksomhedRapport
     */
    public function getVirksomhedOversigtRapport() {
        return $this->virksomhedOversigtRapport;
    }

    /**
     * Set editUrl
     *
     * @param string $title
     *
     * @return RapportSektion
     */
    public function setEditUrl($url) {
        $this->editUrl = $url;

        return $this;
    }

    /**
     * Get editUrl
     *
     * @return string
     */
    public function getEditUrl() {
        return $this->editUrl;
    }

    /**
     * Returns the possible types of RapportSektion.
     *
     * Values are parses from DiscriminatorMap annotation.
     *
     * @return array
     *   DiscriminatorMap annotation values.
     *
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     */
    public static function getRapportSektionTypes($keys = FALSE) {
        $refClass = new \ReflectionClass(RapportSektion::class);
        $annotationReader = new AnnotationReader();

        /** @var DiscriminatorMap $discriminatorMapAnn */
        $discriminatorMapAnn = $annotationReader->getClassAnnotation($refClass, 'Doctrine\ORM\Mapping\DiscriminatorMap');

        return $keys ? array_keys($discriminatorMapAnn->value) : $discriminatorMapAnn->value;
    }

    /**
     * Get section class by type.
     *
     * @param $type
     * @return string
     */
    public static function getRapportSektionClassByType($type, $short = FALSE) {
        $types = self::getRapportSektionTypes();
        if (empty($types[$type])) {
            return NULL;
        }
        return $short ? $types[$type] : 'AppBundle\\Entity\\RapportSektioner\\' . $types[$type];
    }

    /**
     * Returns the FormType for this RapportSektion.
     *
     * @return FormTypeInterface
     *   Dedicated FormType.
     */
    public function getFormType() {
        return new RapportSektionType();
    }

    /**
     * Returns the type of this RapportSektion.
     *
     * This is a value stored in the descriminator field.
     *
     * @return string
     *   Section Type.
     */
    public function getType() {
        $class = (new \ReflectionClass($this))->getShortName();
        return array_search($class, self::getRapportSektionTypes());
    }

    /**
     * Get extras default values
     *
     * @return array
     */
    public static function getExtrasDefault() {
        return array();
    }

    /**
     * Get extras keys that should be filled in form.
     *
     * @return array
     */
    public static function getExtrasInputKeys() {
        return array_keys(self::getExtrasDefault());
    }

    /**
     * Get extras key value.
     *
     * @return float
     */
    public function getExtrasKeyValue($key) {
        $extras = $this->getExtras();
        return isset($extras[$key]) ? $extras[$key] : NULL;
    }

    /**
     * Set extras key value.
     *
     * @return RapportSektion
     */
    public function setExtrasKeyValue($key, $value) {
        $this->extras[$key] = $value;
        return $this;
    }

    /**
     * Defines allowed actions with SektionType.
     *
     * @return array
     */
    protected function allowedActions() {
        return array(
            self::ACTION_ADD
        );
    }

    /**
     * Checks is action allowed on SektionType.
     *
     * @param $action
     * @return bool
     */
    public function isAllowed($action) {
        return in_array($action, $this->allowedActions());
    }

    /**
     * Gets a list of fields that support population form default values.
     */
    public static function getDefaultableTextFields() {
        return array('text');
    }

    /**
     * Get rapport sections
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRapportSections() {
        if (!empty($this->virksomhedOversigtRapport)) {
            return $this->virksomhedOversigtRapport->getRapportOversigtSektioner();
        } elseif (!empty($this->bygningOversigtRapport)) {
            return $this->bygningOversigtRapport->getRapportOversigtSektioner();
        }
        return new ArrayCollection();
    }

    /**
     * Get rapport
     *
     * @return object|null
     */
    public function getRapport() {
        if (!empty($this->virksomhedOversigtRapport)) {
            return $this->virksomhedOversigtRapport;
        } elseif (!empty($this->bygningOversigtRapport)) {
            return $this->bygningOversigtRapport;
        }
        return Null;
    }

    /**
     * Makes defaultable fields NULL, if they are using standard value.
     *
     * @param EntityManagerInterface $em
     *   Entity manager.
     */
    protected function nullDefaultableTextFields(EntityManagerInterface $em) {
        $defaultableTextFields = $this::getDefaultableTextFields();
        foreach ($defaultableTextFields as $field) {
            /** @var ReportTextRepository $textRepository */
            $textRepository = $em->getRepository('AppBundle:ReportText');

            /** @var ReportText $defaultText */
            $defaultText = $textRepository->getDefaultText($this->getType(), $field);

            if ($defaultText) {
                // Checking if it is an extra field.
                $isExtraField = !property_exists($this, $field);

                if ($isExtraField) {
                    if (strcmp($this->getExtrasKeyValue($field), $defaultText->getBody()) == 0){
                        $this->setExtrasKeyValue($field, NULL);
                    }
                }
                else {
                    if (strcmp($this->{$field}, $defaultText->getBody()) == 0){
                        $this->{$field} = NULL;
                    }
                }

            }
        }
    }

    /**
     * Post load handler.
     *
     * Calls init.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @see init().
     */
    public function postLoad(LifecycleEventArgs $event) {
        /** @var EntityManagerInterface $em */
        $em = $event->getEntityManager();

        $this->init($em);
    }

    /**
     * PrePersist load handler.
     *
     * @ORM\PrePersist
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @see nullDefaultableTextFields.
     */
    public function prePersist(LifecycleEventArgs $event) {
        $this->nullDefaultableTextFields($event->getEntityManager());
    }

    /**
     * PreUpdate load handler.
     *
     * @ORM\PreUpdate
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @see nullDefaultableTextFields.
     */
    public function preUpdate(LifecycleEventArgs $event) {
        $this->nullDefaultableTextFields($event->getEntityManager());
    }

}

