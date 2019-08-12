<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Annotations\Calculated;
use AppBundle\Calculation\Calculation;
use AppBundle\DBAL\Types\Energiforsyning\NavnType;
use AppBundle\DBAL\Types\Energiforsyning\InternProduktion\PrisgrundlagType;
use AppBundle\Entity\Energiforsyning\InternProduktion;
use AppBundle\Entity\Energiforsyning;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OrderBy;
use Doctrine\ORM\Event\LifecycleEventArgs;
use JMS\Serializer\Annotation as JMS;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;
use PHPExcel_Calculation_Financial as Excel;
use PHPExcel_Calculation_Functions as ExcelError;

/**
 * VirksomhedRapport
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\VirksomhedRapportRepository")
 * @ORM\HasLifecycleCallbacks
 */
class VirksomhedRapport
{

    use BlameableEntity;
    use TimestampableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="Virksomhed", inversedBy="rapport", fetch="EAGER")
     **/
    protected $virksomhed;

    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     */
    protected $version;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Datering", type="date")
     */
    protected $datering;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datoForDrift", type="date", nullable=true)
     */
    protected $datoForDrift;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="besparelseAarEt", type="float", scale=4, nullable=true)
     */
    protected $besparelseAarEt;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtbesparelseAarEt", type="float", scale=4, nullable=true)
     */
    protected $fravalgtBesparelseAarEt;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="besparelseVarmeGUF", type="float", scale=4, nullable=true)
     */
    protected $besparelseVarmeGUF;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtBesparelseVarmeGUF", type="float", scale=4, nullable=true)
     */
    protected $fravalgtBesparelseVarmeGUF;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="besparelseVarmeGAF", type="float", nullable=true)
     */
    protected $besparelseVarmeGAF;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtBesparelseVarmeGAF", type="float", nullable=true)
     */
    protected $fravalgtBesparelseVarmeGAF;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="besparelseCO2", type="float", nullable=true)
     */
    protected $besparelseCO2;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtBesparelseCO2", type="float", nullable=true)
     */
    protected $fravalgtBesparelseCO2;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="besparelseEl", type="float", nullable=true)
     */
    protected $besparelseEl;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtBesparelseEl", type="float", nullable=true)
     */
    protected $fravalgtBesparelseEl;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="co2BesparelseEl", type="float", nullable=true)
     */
    protected $co2BesparelseEl;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="co2BesparelseVarme", type="float", nullable=true)
     */
    protected $co2BesparelseVarme;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="BaselineCO2El", type="float", nullable=true)
     */
    protected $BaselineCO2El;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="BaselineCO2Varme", type="float", nullable=true)
     */
    protected $BaselineCO2Varme;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="BaselineCO2Samlet", type="float", nullable=true)
     */
    protected $BaselineCO2Samlet;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtBaselineCO2Samlet", type="float", nullable=true)
     */
    protected $fravalgtBaselineCO2Samlet;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="co2BesparelseElFaktor", type="float", nullable=true)
     */
    protected $co2BesparelseElFaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="co2BesparelseVarmeFaktor", type="float", nullable=true)
     */
    protected $co2BesparelseVarmeFaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="co2BesparelseSamletFaktor", type="float", nullable=true)
     */
    protected $co2BesparelseSamletFaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtCo2BesparelseSamletFaktor", type="float", nullable=true)
     */
    protected $fravalgtCo2BesparelseSamletFaktor;

    /**
     * @var float
     *
     * @ORM\Column(name="BaselineEl", type="decimal", precision=16, scale=4, nullable=true)
     */
    protected $BaselineEl;

    /**
     * @var float
     *
     * @ORM\Column(name="BaselineVarmeGUF", type="decimal", precision=16, scale=4, nullable=true)
     */
    protected $BaselineVarmeGUF;

    /**
     * @var float
     *
     * @ORM\Column(name="BaselineVarmeGAF", type="decimal", precision=16, scale=4, nullable=true)
     */
    protected $BaselineVarmeGAF;

    /**
     * @var float
     *
     * @ORM\Column(name="BaselineVand", type="decimal", precision=16, scale=4, nullable=true)
     */
    protected $BaselineVand;

    /**
     * @var float
     *
     * @ORM\Column(name="BaselineStrafAfkoeling", type="decimal", precision=16, scale=4, nullable=true)
     */
    protected $BaselineStrafAfkoeling;

    /**
     * @var float
     *
     * @ORM\Column(name="faktorPaaVarmebesparelse", type="decimal", scale=4, nullable=true)
     */
    protected $faktorPaaVarmebesparelse;

    /**
     * @var float
     *
     * @ORM\Column(name="energiscreening", type="decimal", precision=16, scale=4, nullable=true)
     */
    protected $energiscreening;

    /**
     * Tilvalgt TotalInvestering = sum af alle tiltags anlægsinvesteringer
     *
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="anlaegsinvestering", type="float", nullable=true)
     */
    protected $anlaegsinvestering;

    /**
     * Fravlgt TotalInvestering = sum af alle tiltags anlægsinvesteringer
     *
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtAnlaegsinvestering", type="float", nullable=true)
     */
    protected $fravalgtAnlaegsinvestering;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float", nullable=true)
     */
    protected $nutidsvaerdiSetOver15AarKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtNutidsvaerdiSetOver15AarKr", type="float", nullable=true)
     */
    protected $fravalgtNutidsvaerdiSetOver15AarKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="mtmFaellesomkostninger", type="float", nullable=true)
     */
    protected $mtmFaellesomkostninger;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="implementering", type="float", nullable=true)
     */
    protected $implementering;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtimplementering", type="float", nullable=true)
     */
    protected $fravalgtImplementering;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="faellesomkostninger", type="float", nullable=true)
     */
    protected $faellesomkostninger;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="internRenteInklFaellesomkostninger", type="float", nullable=true)
     */
    protected $internRenteInklFaellesomkostninger;

    /**
     * @var integer
     *
     * @ORM\Column(name="laanLoebetid", type="integer", nullable=true)
     */
    protected $laanLoebetid = 15;

    /**
     * @var boolean
     *
     * @ORM\Column(name="elena", type="boolean", nullable=true)
     */
    protected $elena = FALSE;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ava", type="boolean", nullable=true)
     */
    protected $ava = FALSE;

    /**
     * @var array of float
     *
     * @Calculated
     * @ORM\Column(name="cashFlow15", type="array")
     */
    protected $cashFlow15;

    /**
     * @var array of float
     *
     * @Calculated
     * @ORM\Column(name="cashFlow30", type="array")
     */
    protected $cashFlow30;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="energibudgetVarme", type="float", nullable=true)
     */
    protected $energibudgetVarme;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="energibudgetEl", type="float", nullable=true)
     */
    protected $energibudgetEl;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="fravalgtBesparelseDriftOgVedligeholdelse", type="float", nullable=true)
     */
    protected $fravalgtBesparelseDriftOgVedligeholdelse;

    /**
     * @var ArrayCollection $rapporter
     */
    protected $rapporter;

    /**
     * @var float
     *
     * @ORM\Column(name="Genopretning", type="decimal", nullable=true)
     */
    protected $genopretning;

    /**
     * @var float
     *
     * @ORM\Column(name="genopretningForImplementeringsomkostninger", type="decimal", nullable=true)
     */
    protected $genopretningForImplementeringsomkostninger;

    /**
     * @var float
     *
     * @ORM\Column(name="Modernisering", type="decimal", nullable=true)
     */
    protected $modernisering;

    /**
     * @var float
     *
     * @ORM\Column(name="FravalgtGenopretning", type="decimal", nullable=true)
     */
    protected $fravalgtGenopretning;

    /**
     * @var float
     *
     * @ORM\Column(name="FravalgtModernisering", type="decimal", nullable=true)
     */
    protected $fravalgtModernisering;

    /**
     * @var array
     *
     * @Calculated
     * @ORM\Column(name="cashFlow", type="array")
     */
    protected $cashFlow;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datering = new \DateTime();
        $this->version = 1;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function __toString()
    {
        /** @var Virksomhed $virksomhed */
        $virksomhed = $this->getVirksomhed();
        if ($virksomhed->getAddress()) {
            return $virksomhed->getAddress();
        }
        if ($virksomhed->getName()) {
            return $virksomhed->getName();
        }
        return strval($virksomhed->getId());
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fravalgtBesparelseDriftOgVedligeholdelse
     *
     * @param float $fravalgtBesparelseDriftOgVedligeholdelse
     * @return VirksomhedRapport
     */
    public function setFravalgtBesparelseDriftOgVedligeholdelse($fravalgtBesparelseDriftOgVedligeholdelse)
    {
        $this->fravalgtBesparelseDriftOgVedligeholdelse = $fravalgtBesparelseDriftOgVedligeholdelse;
        return $this;
    }

    /**
     * @return float
     */
    public function getFravalgtBesparelseDriftOgVedligeholdelse()
    {
        return $this->fravalgtBesparelseDriftOgVedligeholdelse;
    }

    /**
     * Set BaselineCO2El
     *
     * @param float $BaselineCO2El
     * @return VirksomhedRapport
     */
    public function setBaselineCO2El($BaselineCO2El)
    {
        $this->BaselineCO2El = $BaselineCO2El;
        return $this;
    }

    /**
     * @return float
     */
    public function getBaselineCO2El()
    {
        return $this->BaselineCO2El;
    }

    /**
     * @param float $BaselineCO2Varme
     */
    public function setBaselineCO2Varme($BaselineCO2Varme)
    {
        $this->BaselineCO2Varme = $BaselineCO2Varme;
    }

    /**
     * @return float
     */
    public function getBaselineCO2Varme()
    {
        return $this->BaselineCO2Varme;
    }

    /**
     * @param float $BaselineCO2Samlet
     */
    public function setBaselineCO2Samlet($BaselineCO2Samlet)
    {
        $this->BaselineCO2Samlet = $BaselineCO2Samlet;
    }

    /**
     * @return float
     */
    public function getBaselineCO2Samlet()
    {
        return $this->BaselineCO2Samlet;
    }

    /**
     * @param float $co2BesparelseElFaktor
     */
    public function setCo2BesparelseElFaktor($co2BesparelseElFaktor)
    {
        $this->co2BesparelseElFaktor = $co2BesparelseElFaktor;
    }

    /**
     * @return float
     */
    public function getCo2BesparelseElFaktor()
    {
        return $this->co2BesparelseElFaktor;
    }

    /**
     * @param float $co2BesparelseVarmeFaktor
     */
    public function setCo2BesparelseVarmeFaktor($co2BesparelseVarmeFaktor)
    {
        $this->co2BesparelseVarmeFaktor = $co2BesparelseVarmeFaktor;
    }

    /**
     * @return float
     */
    public function getCo2BesparelseVarmeFaktor()
    {
        return $this->co2BesparelseVarmeFaktor;
    }

    /**
     * @param float $co2BesparelseSamletFaktor
     */
    public function setCo2BesparelseSamletFaktor($co2BesparelseSamletFaktor)
    {
        $this->co2BesparelseSamletFaktor = $co2BesparelseSamletFaktor;
    }

    /**
     * @return float
     */
    public function getCo2BesparelseSamletFaktor()
    {
        return $this->co2BesparelseSamletFaktor;
    }

    /**
     * @param float $fravalgtCo2BesparelseSamletFaktor
     */
    public function setFravalgtCo2BesparelseSamletFaktor($fravalgtCo2BesparelseSamletFaktor)
    {
        $this->fravalgtCo2BesparelseSamletFaktor = $fravalgtCo2BesparelseSamletFaktor;
    }

    /**
     * @return float
     */
    public function getFravalgtCo2BesparelseSamletFaktor()
    {
        return $this->fravalgtCo2BesparelseSamletFaktor;
    }

    /**
     * Set cashFlow15
     *
     * @param float $cashFlow15
     * @return VirksomhedRapport
     */
    public function setCashFlow15($cashFlow15)
    {
        $this->cashFlow15 = $cashFlow15;
        return $this;
    }

    /**
     * Get cashFlow15
     *
     * @return array of float
     */
    public function getCashFlow15()
    {
        return $this->cashFlow15;
    }

    /**
     * Set cashFlow30
     *
     * @param float $cashFlow30
     * @return VirksomhedRapport
     */
    public function setCashFlow30($cashFlow30)
    {
        $this->cashFlow30 = $cashFlow30;
        return $this;
    }

    /**
     * Get cashFlow30
     *
     * @return array of float
     */
    public function getCashFlow30()
    {
        return $this->cashFlow30;
    }

    /**
     * Set energibudgetVarme
     *
     * @param float $energibudgetVarme
     * @return VirksomhedRapport
     */
    public function setEnergibudgetVarme($energibudgetVarme)
    {
        $this->energibudgetVarme = $energibudgetVarme;
        return $this;
    }

    /**
     * Get energibudgetVarme
     *
     * @return float
     */
    public function getEnergibudgetVarme()
    {
        return $this->energibudgetVarme;
    }

    /**
     * Set energibudgetEl
     *
     * @param float $energibudgetEl
     * @return VirksomhedRapport
     */
    public function setEnergibudgetEl($energibudgetEl)
    {
        $this->energibudgetEl = $energibudgetEl;
        return $this;
    }

    /**
     * Get energibudgetEl
     *
     * @return float
     */
    public function getEnergibudgetEl()
    {
        return $this->energibudgetEl;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return VirksomhedRapport
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the "full" version with nummeric building status appended
     *
     * @return string
     */
    public function getFullVersion()
    {
        return 'Virksomhed ' . $this->getVirksomhed() . ' / Itteration: ' . $this->version;
    }

    /**
     * Set datering
     *
     * @param \DateTime $datering
     * @return VirksomhedRapport
     */
    public function setDatering($datering)
    {
        $this->datering = $datering;

        return $this;
    }

    /**
     * Get datering
     *
     * @return \DateTime
     */
    public function getDatering()
    {
        return $this->datering;
    }

    /**
     * Set datoForDrift
     *
     * @param \DateTime $datoForDrift
     * @return VirksomhedRapport
     */
    public function setDatoForDrift($datoForDrift)
    {
        $this->datoForDrift = $datoForDrift;

        return $this;
    }

    /**
     * Get datoForDrift
     *
     * @return \DateTime
     */
    public function getDatoForDrift()
    {
        return $this->datoForDrift;
    }

    /**
     * Set virksomhed
     *
     * @param Virksomhed $virksomhed
     * @return VirksomhedRapport
     */
    public function setVirksomhed(Virksomhed $virksomhed = NULL)
    {
        $this->virksomhed = $virksomhed;

        return $this;
    }

    /**
     * Get virksomhed
     *
     * @return Virksomhed
     */
    public function getVirksomhed()
    {
        return $this->virksomhed;
    }

    /**
     * Set besparelseAarEt
     *
     * @param float $besparelseAarEt
     * @return VirksomhedRapport
     */
    public function setBesparelseAarEt($besparelseAarEt)
    {
        $this->besparelseAarEt = $besparelseAarEt;
        return $this;
    }

    /**
     * Get total besparelseVarme
     *
     * @return float
     */
    public function getBesparelseAarEt()
    {
        return $this->besparelseAarEt;
    }

    /**
     * Set fravalgtBesparelseAarEt
     *
     * @param float $fravalgtBesparelseAarEt
     * @return VirksomhedRapport
     */
    public function setFravalgtBesparelseAarEt($fravalgtBesparelseAarEt)
    {
        $this->fravalgtBesparelseAarEt = $fravalgtBesparelseAarEt;
        return $this;
    }

    /**
     * Get total besparelseVarme for fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtBesparelseAarEt()
    {
        return $this->fravalgtBesparelseAarEt;
    }

    /**
     * Get total besparelseVarme
     *
     * @return float
     */
    public function getBesparelseVarme()
    {
        return $this->besparelseVarmeGUF + $this->besparelseVarmeGAF;
    }

    /**
     * Get total besparelseVarme for fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtBesparelseVarme()
    {
        return $this->fravalgtBesparelseVarmeGUF + $this->fravalgtBesparelseVarmeGAF;
    }

    /**
     * Set besparelseVarmeGUF
     *
     * @param float $besparelseVarmeGUF
     * @return VirksomhedRapport
     */
    public function setBesparelseVarmeGUF($besparelseVarmeGUF)
    {
        $this->besparelseVarmeGUF = $besparelseVarmeGUF;
        return $this;
    }

    /**
     * Get besparelseVarmeGUF
     *
     * @return float
     */
    public function getBesparelseVarmeGUF()
    {
        return $this->besparelseVarmeGUF;
    }

    /**
     * Set fravalgtBesparelseVarmeGUF
     *
     * @param float $fravalgtBesparelseVarmeGUF
     * @return VirksomhedRapport
     */
    public function setFravalgtBesparelseVarmeGUF($fravalgtBesparelseVarmeGUF)
    {
        $this->fravalgtBesparelseVarmeGUF = $fravalgtBesparelseVarmeGUF;
        return $this;
    }

    /**
     * Get besparelseVarmeGUF for fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtBesparelseVarmeGUF()
    {
        return $this->fravalgtBesparelseVarmeGUF;
    }

    /**
     * Set besparelseVarmeGAF
     *
     * @param float $besparelseVarmeGAF
     * @return VirksomhedRapport
     */
    public function setBesparelseVarmeGAF($besparelseVarmeGAF)
    {
        $this->besparelseVarmeGAF = $besparelseVarmeGAF;
        return $this;
    }

    /**
     * Get besparelseVarmeGAF
     *
     * @return float
     */
    public function getBesparelseVarmeGAF()
    {
        return $this->besparelseVarmeGAF;
    }

    /**
     * Set fravalgtBesparelseVarmeGAF
     *
     * @param float $fravalgtBesparelseVarmeGAF
     * @return VirksomhedRapport
     */
    public function setFravalgtBesparelseVarmeGAF($fravalgtBesparelseVarmeGAF)
    {
        $this->fravalgtBesparelseVarmeGAF = $fravalgtBesparelseVarmeGAF;
        return $this;
    }

    /**
     * Get besparelseVarmeGAF for fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtBesparelseVarmeGAF()
    {
        return $this->fravalgtBesparelseVarmeGAF;
    }

    /**
     * Set besparelseCO2
     *
     * @param float $besparelseCO2
     * @return VirksomhedRapport
     */
    public function setBesparelseCO2($besparelseCO2)
    {
        $this->besparelseCO2 = $besparelseCO2;
        return $this;
    }

    /**
     * Get besparelseCO2
     *
     * @return float
     */
    public function getBesparelseCO2()
    {
        return $this->besparelseCO2;
    }

    /**
     * Set fravalgtBesparelseCO2
     *
     * @param float $fravalgtBesparelseCO2
     * @return VirksomhedRapport
     */
    public function setFravalgtBesparelseCO2($fravalgtBesparelseCO2)
    {
        $this->fravalgtBesparelseCO2 = $fravalgtBesparelseCO2;
        return $this;
    }

    /**
     * Get besparelseCO2 for fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtBesparelseCO2()
    {
        return $this->fravalgtBesparelseCO2;
    }

    /**
     * Set anlaegsinvestering
     *
     * @param float $anlaegsinvestering
     * @return VirksomhedRapport
     */
    public function setAnlaegsinvestering($anlaegsinvestering)
    {
        $this->anlaegsinvestering = $anlaegsinvestering;
        return $this;
    }

    /**
     * Get anlaegsinvestering
     *
     * @return float
     */
    public function getAnlaegsinvestering()
    {
        return $this->anlaegsinvestering;
    }

    /**
     * Set fravalgtAnlaegsinvestering
     *
     * @param float $fravalgtAnlaegsinvestering
     * @return VirksomhedRapport
     */
    public function setFravalgtAnlaegsinvestering($fravalgtAnlaegsinvestering)
    {
        $this->fravalgtAnlaegsinvestering = $fravalgtAnlaegsinvestering;

        return $this;
    }

    /**
     * Get fravalgtAnlaegsinvestering
     *
     * @return float
     */
    public function getFravalgtAnlaegsinvestering()
    {
        return $this->fravalgtAnlaegsinvestering;
    }

    /**
     * Set besparelseEl
     *
     * @param integer $besparelseEl
     * @return VirksomhedRapport
     */
    public function setBesparelseEl($besparelseEl)
    {
        $this->besparelseEl = $besparelseEl;

        return $this;
    }

    /**
     * Get besparelseEl
     *
     * @return float
     */
    public function getBesparelseEl()
    {
        return $this->besparelseEl;
    }

    /**
     * Set co2BesparelseVarme

     * @param float $co2BesparelseEl
     * @return VirksomhedRapport
     */
    public function setCo2BesparelseEl($co2BesparelseEl)
    {
        $this->co2BesparelseEl = $co2BesparelseEl;
        return $this;
    }
    /**
     * Get co2besparelseEl
     *
     * @return float
     */
    public function getCo2BesparelseEl()
    {
        return $this->co2BesparelseEl;
    }

    /**
     * Set co2BesparelseVarme

     * @param float $co2BesparelseVarme
     * @return VirksomhedRapport
     */
    public function setCo2BesparelseVarme($co2BesparelseVarme)
    {
        $this->co2BesparelseVarme = $co2BesparelseVarme;
        return $this;
    }

    /**
     * Get co2besparelseVarme
     *
     * @return float
     */
    public function getCo2BesparelseVarme()
    {
        return $this->co2BesparelseVarme;
    }

    /**
     * Set fravalgtBesparelseEl for fravalgte tiltag

     * @param float $fravalgtBesparelseEl
     * @return VirksomhedRapport
     */
    public function setFravalgtBesparelseEl($fravalgtBesparelseEl)
    {
        $this->fravalgtBesparelseEl = $fravalgtBesparelseEl;
        return $this;
    }

    /**
     * Get fravalgtBesparelseEl
     *
     * @return float
     */
    public function getFravalgtBesparelseEl()
    {
        return $this->fravalgtBesparelseEl;
    }

    /**
     * Set BaselineEl
     *
     * @param integer $baselineEl
     * @return VirksomhedRapport
     */
    public function setBaselineEl($baselineEl)
    {
        $this->BaselineEl = $baselineEl;

        return $this;
    }

    /**
     * Get BaselineEl
     *
     * @return integer
     */
    public function getBaselineEl()
    {
        return $this->BaselineEl;
    }

    /**
     * Set BaselineVarmeGUF
     *
     * @param integer $baselineVarmeGUF
     * @return VirksomhedRapport
     */
    public function setBaselineVarmeGUF($baselineVarmeGUF)
    {
        $this->BaselineVarmeGUF = $baselineVarmeGUF;

        return $this;
    }

    /**
     * Get BaselineVarmeGUF
     *
     * @return integer
     */
    public function getBaselineVarmeGUF()
    {
        return $this->BaselineVarmeGUF;
    }

    /**
     * Set BaselineVarmeGAF
     *
     * @param integer $baselineVarmeGAF
     * @return VirksomhedRapport
     */
    public function setBaselineVarmeGAF($baselineVarmeGAF)
    {
        $this->BaselineVarmeGAF = $baselineVarmeGAF;

        return $this;
    }

    /**
     * Get BaselineVarmeGAF
     *
     * @return integer
     */
    public function getBaselineVarmeGAF()
    {
        return $this->BaselineVarmeGAF;
    }

    /**
     * Get BaselineVarme
     *
     * @return integer
     */
    public function getBaselineVarme()
    {
        return $this->BaselineVarmeGAF + $this->BaselineVarmeGUF;
    }

    /**
     * Set BaselineVand
     *
     * @param float $baselineVand
     * @return VirksomhedRapport
     */
    public function setBaselineVand($baselineVand)
    {
        $this->BaselineVand = $baselineVand;

        return $this;
    }

    /**
     * Get BaselineVand
     *
     * @return integer
     */
    public function getBaselineVand()
    {
        return $this->BaselineVand;
    }

    /**
     * Set BaselineStrafAfkoeling
     *
     * @param integer $baselineStrafAfkoeling
     * @return VirksomhedRapport
     */
    public function setBaselineStrafAfkoeling($baselineStrafAfkoeling)
    {
        $this->BaselineStrafAfkoeling = $baselineStrafAfkoeling;

        return $this;
    }

    /**
     * Get BaselineStrafAfkoeling
     *
     * @return integer
     */
    public function getBaselineStrafAfkoeling()
    {
        return $this->BaselineStrafAfkoeling;
    }

    /**
     * Set faktorPaaVarmebesparelse
     *
     * @param float $faktorPaaVarmebesparelse
     * @return VirksomhedRapport
     */
    public function setFaktorPaaVarmebesparelse($faktorPaaVarmebesparelse)
    {
        $this->faktorPaaVarmebesparelse = $faktorPaaVarmebesparelse;

        return $this;
    }

    /**
     * Get faktorPaaVarmebesparelse
     *
     * @return float
     */
    public function getFaktorPaaVarmebesparelse()
    {
        return $this->faktorPaaVarmebesparelse;
    }

    /**
     * Set energiscreening
     *
     * @param integer $energiscreening
     * @return VirksomhedRapport
     */
    public function setEnergiscreening($energiscreening)
    {
        $this->energiscreening = $energiscreening;

        return $this;
    }

    /**
     * Get Energiscreening
     *
     * @return integer
     */
    public function getEnergiscreening()
    {
        return $this->energiscreening;
    }

    /**
     * Set laanLoebetid
     *
     * @param integer $laanLoebetid
     * @return VirksomhedRapport
     */
    public function setLaanLoebetid($laanLoebetid)
    {
        $this->laanLoebetid = $laanLoebetid;

        return $this;
    }

    /**
     * Get LaanLoebetid
     *
     * @return integer
     */
    public function getLaanLoebetid()
    {
        return $this->laanLoebetid;
    }

    /**
     * Set nutidsvaerdiSetOver15AarKr
     *
     * @param float $nutidsvaerdiSetOver15AarKr
     * @return VirksomhedRapport
     */
    public function setNutidsvaerdiSetOver15AarKr($nutidsvaerdiSetOver15AarKr)
    {
        $this->nutidsvaerdiSetOver15AarKr = $nutidsvaerdiSetOver15AarKr;
        return $this;
    }

    /**
     * Get nutidsvaerdiSetOver15AarKr.
     *
     * @return float
     */
    public function getNutidsvaerdiSetOver15AarKr()
    {
        return $this->nutidsvaerdiSetOver15AarKr;
    }

    /**
     * Set fravalgtNutidsvaerdiSetOver15AarKr
     *
     * @param float $fravalgtNutidsvaerdiSetOver15AarKr
     * @return VirksomhedRapport
     */
    public function setFravalgtNutidsvaerdiSetOver15AarKr($fravalgtNutidsvaerdiSetOver15AarKr)
    {
        $this->fravalgtNutidsvaerdiSetOver15AarKr = $fravalgtNutidsvaerdiSetOver15AarKr;
        return $this;
    }

    /**
     * Get nutidsvaerdiSetOver15AarKr for fravlgte tiltag
     *
     * @return float
     */
    public function getFravalgtNutidsvaerdiSetOver15AarKr()
    {
        return $this->fravalgtNutidsvaerdiSetOver15AarKr;
    }

    /**
     * Set elena
     *
     * @param string $elena
     * @return VirksomhedRapport
     */
    public function setElena($elena)
    {
        $this->elena = $elena;

        return $this;
    }

    /**
     * Get elena
     *
     * @return boolean
     */
    public function getElena()
    {
        return $this->elena;
    }

    /**
     * Set genopretning
     *
     * @param float $genopretning
     * @return VirksomhedRapport
     */
    public function setGenopretning($genopretning)
    {
        $this->genopretning = $genopretning;
        return $this;
    }

    /**
     * Get genopretning
     *
     * @return float
     */
    public function getGenopretning()
    {
        return $this->genopretning;
    }

    /**
     * Set genopretningForImplementeringsomkostninger
     *
     * @param float $genopretningForImplementeringsomkostninger
     * @return VirksomhedRapport
     */
    public function setGenopretningForImplementeringsomkostninger($genopretningForImplementeringsomkostninger)
    {
        $this->genopretningForImplementeringsomkostninger = $genopretningForImplementeringsomkostninger;
        return $this;
    }

    public function getGenopretningForImplementeringsomkostninger()
    {
        return $this->genopretningForImplementeringsomkostninger;
    }

    /**
     * Set modernisering
     *
     * @param float $modernisering
     * @return VirksomhedRapport
     */
    public function setModernisering($modernisering)
    {
        $this->modernisering = $modernisering;
        return $this;
    }

    /**
     * Get modernisering
     *
     * @return float
     */
    public function getModernisering()
    {
        return $this->modernisering;
    }

    /**
     * Set fravalgtGenopretning
     *
     * @param float $fravalgtGenopretning
     * @return VirksomhedRapport
     */
    public function setFravalgtGenopretning($fravalgtGenopretning)
    {
        $this->fravalgtGenopretning = $fravalgtGenopretning;
        return $this;
    }

    /**
     * Get genopretning for fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtGenopretning()
    {
        return $this->fravalgtGenopretning;
    }

    /**
     * Set fravalgtModernisering
     *
     * @param float $fravalgtModernisering
     * @return VirksomhedRapport
     */
    public function setFravalgtModernisering($fravalgtModernisering)
    {
        $this->fravalgtModernisering = $fravalgtModernisering;
        return $this;
    }

    /**
     * Get moderniseringfor fravalgte tiltag
     *
     * @return float
     */
    public function getFravalgtModernisering()
    {
        return $this->fravalgtModernisering;
    }

    /**
     * @param boolean $ava
     */
    public function setAva($ava)
    {
        $this->ava = $ava;
    }

    /**
     * @return boolean
     */
    public function getAva()
    {
        return $this->ava;
    }

    /**
     * @var Configuration
     */
    protected $configuration;

    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Set mtmFaellesomkostninger
     *
     * @param float $mtmFaellesomkostninger
     * @return VirksomhedRapport
     */
    public function setMtmFaellesomkostninger($mtmFaellesomkostninger)
    {
        $this->mtmFaellesomkostninger = $mtmFaellesomkostninger;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getMtmFaellesomkostninger()
    {
        return $this->mtmFaellesomkostninger;
    }

    /**
     * Set implementering
     *
     * @param float $implementering
     * @return VirksomhedRapport
     */
    public function setImplementering($implementering)
    {
        $this->implementering = $implementering;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getImplementering()
    {
        return $this->implementering;
    }

    /**
     * Set fravalgtImplementering
     *
     * @param float $fravalgtImplementering
     * @return VirksomhedRapport
     */
    public function setFravalgtImplementering($fravalgtImplementering)
    {
        $this->fravalgtImplementering = $fravalgtImplementering;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getFravalgtImplementering()
    {
        return $this->fravalgtImplementering;
    }

    /**
     * Set internRenteInklFaellesomkostninger
     *
     * @param float $internRenteInklFaellesomkostninger
     * @return VirksomhedRapport
     */
    public function setInternRenteInklFaellesomkostninger($internRenteInklFaellesomkostninger)
    {
        $this->internRenteInklFaellesomkostninger = $internRenteInklFaellesomkostninger;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getInternRenteInklFaellesomkostninger()
    {
        return $this->internRenteInklFaellesomkostninger;
    }

    /**
     * Set faellesomkostninger
     *
     * @param float $faellesomkostninger
     * @return VirksomhedRapport
     */
    public function setFaellesomkostninger($faellesomkostninger)
    {
        $this->faellesomkostninger = $faellesomkostninger;
        return $this;
    }

    /**
     *
     * @return float
     */
    public function getFaellesomkostninger()
    {
        return $this->faellesomkostninger;
    }

    /**
     * Set cashFlow
     *
     * @param float $cashFlow
     * @return VirksomhedRapport
     */
    public function setCashFlow($cashFlow)
    {
        $this->cashFlow = $cashFlow;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getCashFlow()
    {
        return $this->cashFlow;
    }

    protected $propertiesRequiredForCalculation = [
        'BaselineEl',
        'BaselineStrafAfkoeling',
        'BaselineVarmeGAF',
        'BaselineVarmeGUF',
        'energiscreening',
        'faktorPaaVarmebesparelse',
    ];

    public function getPropertiesRequiredForCalculation() {
        return $this->propertiesRequiredForCalculation;
    }

    /**
     * Fetchs array with all associated rapporter
     *
     * @return ArrayCollection
     */
    public function getRapporter() {
        if (!empty($this->rapporter)) {
            return $this->rapporter;
        }

        /** @var Bygning $bygning */
        foreach ($this->getVirksomhed()->getBygninger() as $bygning) {
            /** @var Rapport */
            $rapport = $bygning->getRapport();
            if (empty($rapport)) {
                continue;
            }
            $this->rapporter[$rapport->getId()] = $rapport;
        }
        return $this->rapporter;
    }

    /**
     * Check if calculating this Rapport makes sense.
     * Some values may be required to make a meaningful calculation.
     */
    public function getCalculationWarnings($messages = [])
    {
        $properties = $this->getPropertiesRequiredForCalculation();
        $prefix = 'virksomhed_rapport';
        return Calculation::getCalculationWarnings($this, $properties, $prefix);
    }

    public function calculate()
    {
        /** @var Rapport $rapport */
        foreach ($this->getRapporter() as $rapport) {
            if (!empty($rapport->getCalculationWarnings())) {
                $rapport->calculate();
            }
        }

        $calculationProperties = array(
            'BaselineCO2El',
            'BaselineCO2Varme',
            'BaselineCO2Samlet',
            'besparelseEl',
            'fravalgtBesparelseEl',
            'besparelseVarmeGUF',
            'fravalgtBesparelseVarmeGUF',
            'besparelseVarmeGAF',
            'fravalgtBesparelseVarmeGAF',
            'co2BesparelseEl',
            'co2BesparelseVarme',
            'besparelseCO2',
            'fravalgtBesparelseCO2',
            'co2BesparelseElFaktor',
            'co2BesparelseVarmeFaktor',
            'co2BesparelseSamletFaktor',
            'fravalgtCo2BesparelseSamletFaktor',
            'mtmFaellesomkostninger',
            'implementering',
            'fravalgtGenopretning',
            'fravalgtModernisering',
            'fravalgtImplementering',
            'faellesomkostninger',
            'fravalgtBesparelseDriftOgVedligeholdelse',
            'anlaegsinvestering',
            'fravalgtAnlaegsinvestering',
            'nutidsvaerdiSetOver15AarKr',
            'fravalgtNutidsvaerdiSetOver15AarKr',
            'genopretning',
            'genopretningForImplementeringsomkostninger',
            'modernisering',
            'internRenteInklFaellesomkostninger',
            'energibudgetVarme',
            'energibudgetEl',
            'besparelseAarEt',
            'fravalgtBesparelseAarEt',
            'cashFlow',
            'cashFlow15',
            'cashFlow30',
        );

        foreach ($calculationProperties as $property) {
            $value = 0;
            $getMethod = 'get' . ucfirst($property);
            $setMethod = 'set' . ucfirst($property);

            switch($property) {
                case 'cashFlow';
                    $value = $this->calculateCashFlow();
                    break;

                case 'cashFlow15';
                    $value = $this->calculateCashFlow15();
                    break;

                case 'cashFlow30';
                    $value = $this->calculateCashFlow30();
                    break;

                default:
                    /** @var Rapport $rapport */
                    foreach ($this->getRapporter() as $rapport) {
                        if (method_exists($rapport, $getMethod)) {
                            $value += call_user_func(array($rapport, $getMethod));
                        }
                    }
                    break;
            }

            call_user_func(array($this, $setMethod), $value);
        }
    }

    /**
     * Fetchs cashflow data from reports into array.
     */
    private function calculateCashFlow() {
        $flow = array();
        /** @var Rapport $rapport */
        foreach ($this->getRapporter() as $rapport) {
           foreach ($rapport->getCashFlow() as  $flowProperty => $flowValue) {
               if (empty($flow[$flowProperty])) {
                   $flow[$flowProperty] = $flowValue;
                   continue;
               }
               foreach ($flowValue as $year => $value) {
                   if (empty($flow[$flowProperty][$year])) {
                       $flow[$flowProperty][$year] = $value;
                       continue;
                   }
                   $flow[$flowProperty][$year] += $value;
               }
            }
        }

        return $flow;
    }

    /**
     * Fetchs cashflow15 data from reports into array.
     */
    private function calculateCashFlow15() {
        $flow = array();
        /** @var Rapport $rapport */
        foreach ($this->getRapporter() as $rapport) {
            foreach ($rapport->getCashFlow15() as $flowProperty => $flowValue) {
                if (empty($flow[$flowProperty])) {
                    $flow[$flowProperty] = $flowValue;
                    continue;
                }
                $flow[$flowProperty] += $flowValue;
            }
        }

        return $flow;
    }

    /**
     * Fetchs cashflow30 data from reports into array.
     */
    private function calculateCashFlow30() {
        $flow = array();
        /** @var Rapport $rapport */
        foreach ($this->getRapporter() as $rapport) {
            foreach ($rapport->getCashFlow30() as  $flowProperty => $flowValue) {
                if (empty($flow[$flowProperty])) {
                    $flow[$flowProperty] = $flowValue;
                    continue;
                }

                $flow[$flowProperty] += $flowValue;
            }
        }

        return $flow;
    }

}
