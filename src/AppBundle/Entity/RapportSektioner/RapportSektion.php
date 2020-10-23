<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\RapportSektion\RapportSektionType;
use Doctrine\Common\Annotations\AnnotationReader;
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
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *    "standard" = "RapportSektion",
 *    "forside" = "ForsideRapportSektion",
 *    "kundeinformation" = "KundeinformationRapportSektion",
 *    "opsummering" = "OpsummeringRapportSektion",
 * })
 */
class RapportSektion
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
     * @ORM\Column(name="title", type="string", length=255)
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
     * Rapport oversigt section reference to Bygning rapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Rapport", inversedBy="rapportOversigtSektioner")
     * @ORM\JoinColumn(name="bygning_oversigt_rapport_id", referencedColumnName="id")
     */
    protected $bygningOversigtRapport;

    /**
     * Rapport oversigt section reference to Virksomhed rapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VirksomhedRapport", inversedBy="rapportOversigtSektioner")
     * @ORM\JoinColumn(name="virksomhed_oversigt_rapport_id", referencedColumnName="id")
     */
    protected $virksomhedOversigtRapport;

    /**
     * Constructor
     */
    public function __construct() {
        $this->extras = $this->getExtrasDefault();
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
        $extras = $this->getExtrasInputKeys();
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
        return array();
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

}

