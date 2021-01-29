<?php

namespace AppBundle\Entity\RapportSektioner;

use AppBundle\Calculation\Calculation;
use AppBundle\Entity\Rapport;
use AppBundle\Entity\ReportImage;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * RapportSektion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\RapportSektioner\RapportSektionRepository")
 * @ORM\HasLifecycleCallbacks()
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *    "forside" = "ForsideRapportSektion",
 *    "kontaktinformation" = "KontaktInformationRapportSektion",
 *    "indledning" = "IndledningRapportSektion",
 *    "forudsaetninger" = "ForudsaetningerRapportSektion",
 *    "energiportefoelge" = "EnergiportefoelgeRapportSektion",
 *    "konklusion" = "KonklusionRapportSektion",
 *    "kortlaegning" = "KortlaegningRapportSektion",
 *    "afdelinger" = "AfdelingerRapportSektion",
 *    "opsummering" = "OpsummeringRapportSektion",
 *    "anbefaling" = "AnbefalingRapportSektion",
 *    "faktavirksomhed" = "FaktaOmVirksomhedRapportSektion",
 *    "finansiering" = "FinansieringRapportSektion",
 *    "baeredygtighed" = "BaeredygtighedRapportSektion",
 *    "tiltag" = "TiltagRapportSektion",
 *    "tiltagtable" = "TiltagTableRapportSektion"
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
     * @ORM\Column(name="textPages", type="array")
     */
    private $textPages;

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
     * Runtime variable that containe Rapport type value.
     *
     * Depends on rapport attached to section.
     */
    public $rapportType;

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
     * Rapport screening section reference to Virksomhed rapport
     *
     * @var VirksomhedRapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VirksomhedRapport", inversedBy="rapportScreeningSektioner")
     * @ORM\JoinColumn(name="virksomhed_screening_rapport_id", referencedColumnName="id")
     */
    protected $virksomhedScreeningRapport;

    /**
     * Rapport detailark section reference to Virksomhed rapport
     *
     * @var VirksomhedRapport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VirksomhedRapport", inversedBy="rapportDetailarkSektioner")
     * @ORM\JoinColumn(name="virksomhed_detailark_rapport_id", referencedColumnName="id")
     */
    protected $virksomhedDetailarkRapport;

    /**
     * Constructor
     *
     * @param array $params
     */
    public function __construct($params = array()) {
        $this->extras = $this->getExtrasDefault();
        if (!empty($params['rapportType'])) {
            $this->setRapportType($params['rapportType']);
        }
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

        if (!empty($this->virksomhedOversigtRapport)) {
            $this->setRapportType(VirksomhedRapport::RAPPORT_ENERGISYN);
        } elseif (!empty($this->virksomhedScreeningRapport)) {
            $this->setRapportType(VirksomhedRapport::RAPPORT_SCREENING);
        } elseif (!empty($this->virksomhedDetailarkRapport)) {
            $this->setRapportType(VirksomhedRapport::RAPPORT_DETAILARK);
        }

        foreach ($defaultableTextFields as $field) {
            // Checking if it is an extra field.
            $isExtraField = !property_exists($this, $field);

            $fieldValue = $isExtraField ? $this->getExtrasKeyValue($field) : $this->{$field};

            // If entity field is NULL, use a default value.
            if ($fieldValue === NULL) {
                /** @var ReportTextRepository $textRepository */
                $textRepository = $em->getRepository('AppBundle:ReportText');

                /** @var ReportText $defaultText */
                $defaultText = $textRepository->getDefaultText($this->getType(), $this->getRapportType(), $field);
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

        if (property_exists($this, 'filepath') && $this->getFilepath() == NULL) {
            /** @var ReportImage $defaultImage */
            if ($defaultImage = $em->getRepository('AppBundle:ReportImage')->getDefaultImage($this->getType(), $this->getRapportType())) {
                $this->setFilepathString($defaultImage->getFilepath());
            }
        }
        // Handle case if saved files does not exist.
        elseif (property_exists($this, 'filepath') && !is_file($this->getFilepath())) {
            $this->setFilepath(NULL);
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
     * Get section title
     *
     * @return string
     */
    public function getSectionTitle() {
        return $this->getTitle() ?: $this->getType();
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
     * Set text
     *
     * @param string $textPages
     *
     * @return RapportSektion
     */
    public function setTextPages($textPages) {
        $this->textPages = $textPages;

        return $this;
    }

    /**
     * Get textPages
     *
     * @return array
     */
    public function getTextPages() {
        return $this->textPages;
    }

    /**
     * Get text pages filtered by show after key.
     *
     * @return array
     */
    public function getTextPagesFiltered($showAfter = NULL) {
        return empty($this->textPages) ? [] : array_filter($this->textPages, function($textPage) use ($showAfter) {
            if (empty($showAfter)) {
                return empty($textPage['showAfter']);
            }
            return !empty($textPage['showAfter']) && $textPage['showAfter'] == $showAfter;
        });
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
     * Set virksomhedScreeningRapport
     *
     * @param \AppBundle\Entity\VirksomhedRapport $virksomhedScreeningRapport
     * @return RapportSektion
     */
    public function setVirksomhedScreeningRapport(VirksomhedRapport $virksomhedScreeningRapport = NULL) {
        $this->virksomhedScreeningRapport = $virksomhedScreeningRapport;

        return $this;
    }

    /**
     * Get virksomhedScreeningRapport
     *
     * @return \AppBundle\Entity\VirksomhedRapport
     */
    public function getVirksomhedScreeningRapport() {
        return $this->virksomhedScreeningRapport;
    }

    /**
     * Set virksomhedDetailarkRapport
     *
     * @param \AppBundle\Entity\VirksomhedRapport $virksomhedDetailarkRapport
     * @return RapportSektion
     */
    public function setVirksomhedDetailarkRapport(VirksomhedRapport $virksomhedDetailarkRapport = NULL) {
        $this->virksomhedDetailarkRapport = $virksomhedDetailarkRapport;

        return $this;
    }

    /**
     * Get virksomhedDetailarkRapport
     *
     * @return \AppBundle\Entity\VirksomhedRapport
     */
    public function getVirksomhedDetailarkRapport() {
        return $this->virksomhedDetailarkRapport;
    }

    /**
     * Set virksomhedRapport by rapport type.
     *
     * @param \AppBundle\Entity\VirksomhedRapport $virksomhedRapport
     * @return RapportSektion
     */
    public function setVirksomhedRapport(VirksomhedRapport $virksomhedRapport, $rapportType) {
        switch ($rapportType) {
            case VirksomhedRapport::RAPPORT_ENERGISYN:
                $this->setVirksomhedOversigtRapport($virksomhedRapport);
                break;

            case VirksomhedRapport::RAPPORT_SCREENING:
                $this->setVirksomhedScreeningRapport($virksomhedRapport);
                break;

            case VirksomhedRapport::RAPPORT_DETAILARK:
                $this->setVirksomhedDetailarkRapport($virksomhedRapport);
                break;
        }
        $this->setRapportType($rapportType);
        return $this;
    }

    /**
     * Set editUrl
     *
     * @param string $url
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
     * Set rapport type
     *
     * @param string $rapportType
     *
     * @return RapportSektion
     */
    public function setRapportType($rapportType) {
        $this->rapportType = $rapportType;

        return $this;
    }

    /**
     * Get RapportType
     *
     * @return string
     */
    public function getRapportType() {
        return $this->rapportType;
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
        } elseif (!empty($this->virksomhedScreeningRapport)) {
            return $this->virksomhedScreeningRapport->getRapportScreeningSektioner();
        } elseif (!empty($this->virksomhedDetailarkRapport)) {
            return $this->virksomhedDetailarkRapport->getRapportDetailarkSektioner();
        } elseif (!empty($this->bygningOversigtRapport)) {
            return $this->bygningOversigtRapport->getRapportOversigtSektioner();
        }
        return new ArrayCollection();
    }

    /**
     * Returns Tiltag report sections sorted by bygning and tiltag id.
     *
     * @return array
     */
    protected function getRapportTiltagSections() {
        $sections = array();
        $result = $this->getRapportSections();
        foreach ($this->getRapportSections() as $section) {
            if (!($section instanceof TiltagRapportSektion)) {
                continue;
            }
            $bygning = $section->getTiltag()->getRapport()->getBygning();
            $sections[$bygning->getId() . '_' . $section->getTiltagId()] = $section;
        }
        ksort($sections);
        return $sections;
    }

    /**
     * Get rapport
     *
     * @return object|null
     */
    public function getRapport() {
        if (!empty($this->virksomhedOversigtRapport)) {
            return $this->virksomhedOversigtRapport;
        } elseif (!empty($this->virksomhedScreeningRapport)) {
            return $this->virksomhedScreeningRapport;
        } elseif (!empty($this->virksomhedDetailarkRapport)) {
            return $this->virksomhedDetailarkRapport;
        } elseif (!empty($this->bygningOversigtRapport)) {
            return $this->bygningOversigtRapport;
        }
        return Null;
    }

    public function getSamletForbrugGrafData() {
        if (!$this instanceof SamletForbrugGrafDataInterface) {
            return NULL;
        }
        $nuvaerendeForbrug = $this->getNuvaerendeForbrug();
        $optimeretForbrug = $this->getOptimeretForbrug();

        return array(
            'nuvaerende' =>$nuvaerendeForbrug,
            'optimeret' => $optimeretForbrug,
            'reduction' => round((1 - Calculation::divide($optimeretForbrug, $nuvaerendeForbrug)) * 100)
        );
    }

    public function getROIGrafData() {
        if (!$this instanceof ROIGrafDataInterface) {
            return NULL;
        }
        $nuvaerendeForbrugKr = $this->getNuvaerendeForbrugKr();
        $optimeretForbrugKr = $this->getOptimeretForbrugKr();
        $investering = $this->getInvestering();

        $roi = Calculation::divide($investering, $nuvaerendeForbrugKr - $optimeretForbrugKr);
        $labels = array(
            0 => '0',
            5 => '5',
            10 => '10',
            15 => '15',
            20 => '20',
            25 => '25',
            30 => '30',
            35 => 'År',
        );
        $nuvaerende = array();
        $optimeret = array();
        foreach ($labels as $key => $value) {
            $nuvaerende[$key] = $nuvaerendeForbrugKr * $key;
            $optimeret[$key] = $optimeretForbrugKr * $key + $investering;
        }
        return array(
            'data' => array(
                'labels' => array_values($labels),
                'nuvaerende' => array_values($nuvaerende),
                'optimeret' => array_values($optimeret),
            ),
            'investering' => $investering,
            'roi' => $roi,
        );
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
            $defaultText = $textRepository->getDefaultText($this->getType(), $this->getRapportType(), $field);

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

        if (property_exists($this, 'filepath') && $this->getFilepath()) {
            /** @var ReportImage $defaultImage */
            $defaultImage = $em->getRepository('AppBundle:ReportImage')->getDefaultImage($this->getType(), $this->getRapportType());
            if ($this->getFilepath() == $defaultImage->getFilepath()) {
                $this->setFilepath(NULL);
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

    /**
     * PreRemove load handler.
     *
     * @ORM\PreRemove
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     * @see nullDefaultableTextFields.
     */
    public function preRemove(LifecycleEventArgs $event) {
        // Before removing reset default values from entity, to avoid deleting attached files.
        $this->nullDefaultableTextFields($event->getEntityManager());
    }

}

