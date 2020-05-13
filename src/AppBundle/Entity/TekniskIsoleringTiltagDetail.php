<?php

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\VarmeanlaegTiltag\EnergiType;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Annotations\Calculated;
use AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme;

/**
 * TekniskIsoleringTiltagDetail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TekniskIsoleringTiltagDetail extends TiltagDetail
{
    /**
     * @var string
     *
     * @ORM\Column(name="beskrivelseType", type="text")
     */
    protected $beskrivelseType;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TekniskIsoleringTiltagDetail\Komponent", fetch="EAGER")
     */
    protected $komponent;

    /**
     * @var float
     *
     * @ORM\Column(name="driftstidTAar", type="decimal", scale=4)
     */
    protected $driftstidTAar;

    /**
     * @var float
     *
     * @ORM\Column(name="udvDiameterMm", type="decimal", scale=4)
     */
    protected $udvDiameterMm;

    /**
     * @var float
     *
     * @ORM\Column(name="eksistIsolMm", type="decimal", scale=4)
     */
    protected $eksistIsolMm;

    /**
     * @var float
     *
     * @ORM\Column(name="overskrevetPris", type="decimal", scale=4, nullable=true)
     */
    protected $overskrevetPris;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="roerstoerrelseMmAekvivalent", type="float")
     */
    protected $roerstoerrelseMmAekvivalent;

    /**
     * @var float
     *
     * @ORM\Column(name="tempOmgivelC", type="decimal", scale=4)
     */
    protected $tempOmgivelC;

    /**
     * @var float
     *
     * @ORM\Column(name="tempMedieC", type="decimal", scale=4)
     */
    protected $tempMedieC;

    /**
     * @var float
     *
     * @ORM\Column(name="roerlaengdeEllerHoejdeAfVvbM", type="decimal", scale=4)
     */
    protected $roerlaengdeEllerHoejdeAfVvbM;

//  /**
//   * @var float
//   *
//   * @ORM\Column(name="nyttiggjortVarme", type="decimal", scale=4)
//   */
//  protected $nyttiggjortVarme;


    /**
     * @var NyttiggjortVarme
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme", fetch="EAGER")
     * @ORM\JoinColumn(name="nyttiggjortvarme_id", referencedColumnName="id")
     */
    protected $nyttiggjortVarme;

    /**
     * @var float
     *
     * @ORM\Column(name="nyIsolMm", type="decimal", scale=4, nullable=true)
     */
    protected $nyIsolMm;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="varmeledningsevnePaaEksistIsoleringWMK", type="float")
     */
    protected $varmeledningsevnePaaEksistIsoleringWMK;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="varmeledningsevnePaaNyIsoleringWMK", type="float")
     */
    protected $varmeledningsevnePaaNyIsoleringWMK;

    /**
     * @var float
     *
     * @ORM\Column(name="standardinvestKrM2EllerKrM", type="decimal", scale=4, nullable=true)
     */
    protected $standardinvestKrM2EllerKrM;

    /**
     * @var float
     *
     * @ORM\Column(name="prisfaktor", type="decimal", scale=4, nullable=true)
     */
    protected $prisfaktor;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="investeringKr", type="float")
     */
    protected $investeringKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="eksistVarmetabKwh", type="float")
     */
    protected $eksistVarmetabKwh;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nytVarmetabKwh", type="float")
     */
    protected $nytVarmetabKwh;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="varmebespKwhAar", type="float")
     */
    protected $varmebespKwhAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="simpelTilbagebetalingstidAar", type="float")
     */
    protected $simpelTilbagebetalingstidAar;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="nutidsvaerdiSetOver15AarKr", type="float")
     */
    protected $nutidsvaerdiSetOver15AarKr;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="kwhBesparelseElFraVaerket", type="float")
     */
    protected $kwhBesparelseElFraVaerket;

    /**
     * @var float
     *
     * @Calculated
     * @ORM\Column(name="kwhBesparelseVarmeFraVaerket", type="float")
     */
    protected $kwhBesparelseVarmeFraVaerket;

    /**
     * @var float
     * @ORM\Column(name="varmeledningsevneEksistLamelmaatter", type="decimal", scale=4, nullable=true)
     */
    protected $varmeledningsevneEksistLamelmaatter;

    /**
     * @var float
     * @ORM\Column(name="varmeledningsevneNyIsolering", type="decimal", scale=4, nullable=true)
     */
    protected $varmeledningsevneNyIsolering;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->varmeledningsevneEksistLamelmaatter;
    }

    public function setBeskrivelseType($beskrivelseType)
    {
        $this->beskrivelseType = $beskrivelseType;

        return $this;
    }

    public function getBeskrivelseType()
    {
        return $this->beskrivelseType;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setKomponent($komponent)
    {
        $this->komponent = $komponent;

        return $this;
    }

    public function getKomponent()
    {
        return $this->komponent;
    }

    public function setDriftstidTAar($driftstidTAar)
    {
        $this->driftstidTAar = $driftstidTAar;

        return $this;
    }

    public function getDriftstidTAar()
    {
        return $this->driftstidTAar;
    }

    public function setUdvDiameterMm($udvDiameterMm)
    {
        $this->udvDiameterMm = $udvDiameterMm;

        return $this;
    }

    public function getUdvDiameterMm()
    {
        return $this->udvDiameterMm;
    }

    public function setEksistIsolMm($eksistIsolMm)
    {
        $this->eksistIsolMm = $eksistIsolMm;

        return $this;
    }

    public function getEksistIsolMm()
    {
        return $this->eksistIsolMm;
    }

    public function setOverskrevetPris($overskrevetPris)
    {
        $this->overskrevetPris = $overskrevetPris;

        return $this;
    }

    public function getOverskrevetPris()
    {
        return $this->overskrevetPris;
    }

    public function getRoerstoerrelseMmAekvivalent()
    {
        return $this->roerstoerrelseMmAekvivalent;
    }

    public function setTempOmgivelC($tempOmgivelC)
    {
        $this->tempOmgivelC = $tempOmgivelC;

        return $this;
    }

    public function getTempOmgivelC()
    {
        return $this->tempOmgivelC;
    }

    public function setTempMedieC($tempMedieC)
    {
        $this->tempMedieC = $tempMedieC;

        return $this;
    }

    public function getTempMedieC()
    {
        return $this->tempMedieC;
    }

    public function setRoerlaengdeEllerHoejdeAfVvbM($roerlaengdeEllerHoejdeAfVvbM)
    {
        $this->roerlaengdeEllerHoejdeAfVvbM = $roerlaengdeEllerHoejdeAfVvbM;

        return $this;
    }

    public function getRoerlaengdeEllerHoejdeAfVvbM()
    {
        return $this->roerlaengdeEllerHoejdeAfVvbM;
    }

    public function setNyIsolMm($nyIsolMm)
    {
        $this->nyIsolMm = $nyIsolMm;

        return $this;
    }

    public function getNyisolMm()
    {
        return $this->nyIsolMm;
    }

    public function getVarmeledningsevnePaaEksistIsoleringWMK()
    {
        return $this->varmeledningsevnePaaEksistIsoleringWMK;
    }

    public function getVarmeledningsevnePaaNyIsoleringWMK()
    {
        return $this->varmeledningsevnePaaNyIsoleringWMK;
    }

    public function setStandardinvestKrM2EllerKrM($standardinvestKrM2EllerKrM)
    {
        $this->standardinvestKrM2EllerKrM = $standardinvestKrM2EllerKrM;

        return $this;
    }

    public function getStandardinvestKrM2EllerKrM()
    {
        return $this->standardinvestKrM2EllerKrM;
    }

    public function setPrisfaktor($prisfaktor)
    {
        $this->prisfaktor = $prisfaktor;

        return $this;
    }

    public function getPrisfaktor()
    {
        return $this->prisfaktor;
    }

    public function getInvesteringKr()
    {
        return $this->investeringKr;
    }

    public function getEksistVarmetabKwh()
    {
        return $this->eksistVarmetabKwh;
    }

    public function getNytVarmetabKwh()
    {
        return $this->nytVarmetabKwh;
    }

    public function getVarmebespKwhAar()
    {
        return $this->varmebespKwhAar;
    }

    public function getSimpelTilbagebetalingstidAar()
    {
        return $this->simpelTilbagebetalingstidAar;
    }

    public function getNutidsvaerdiSetOver15AarKr()
    {
        return $this->nutidsvaerdiSetOver15AarKr;
    }

    public function getKwhBesparelseElFraVaerket()
    {
        return $this->kwhBesparelseElFraVaerket;
    }

    public function getKwhBesparelseVarmeFraVaerket()
    {
        return $this->kwhBesparelseVarmeFraVaerket;
    }

    public function setVarmeledningsevneEksistLamelmaatter($varmeledningsevneEksistLamelmaatter)
    {
        $this->varmeledningsevneEksistLamelmaatter = $varmeledningsevneEksistLamelmaatter;

        return $this;
    }

    public function getVarmeledningsevneEksistLamelmaatter()
    {
        return $this->varmeledningsevneEksistLamelmaatter;
    }

    public function setVarmeledningsevneNyIsolering($varmeledningsevneNyIsolering)
    {
        $this->varmeledningsevneNyIsolering = $varmeledningsevneNyIsolering;

        return $this;
    }

    public function getVarmeledningsevneNyIsolering()
    {
        return $this->varmeledningsevneNyIsolering;
    }

    /**
     * Sets configuration.
     *
     * @param Configuration $configuration
     * @return $this
     */
    public function setConfiguration(Configuration $configuration) {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * Gets configuration.
     *
     * @return Configuration
     */
    public function getConfiguration() {
        return $this->configuration;
    }

    /**
     * Set nyttiggjortVarme
     *
     * @param \AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme $nyttiggjortVarme
     *
     * @return TekniskIsoleringTiltagDetail
     */
    public function setNyttiggjortVarme(\AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme $nyttiggjortVarme = null)
    {
        $this->nyttiggjortVarme = $nyttiggjortVarme;

        return $this;
    }

    /**
     * Get nyttiggjortVarme
     *
     * @return \AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme
     */
    public function getNyttiggjortVarme()
    {
        return $this->nyttiggjortVarme;
    }

    protected $propertiesRequiredForCalculation = [
        'type',
        'driftstidTAar',
        'eksistIsolMm',
        'udvDiameterMm',
        'tempOmgivelC',
        'roerlaengdeEllerHoejdeAfVvbM',
        'nyttiggjortVarme',
        'nyIsolMm',
        'tempMedieC',
        'prisfaktor',
    ];

    public function getPropertiesRequiredForCalculation()
    {
        // standardinvestKrM2EllerKrM is only required if overskrevetPris is not set
        if (empty($this->overskrevetPris)) {
            if (!in_array('standardinvestKrM2EllerKrM', $this->propertiesRequiredForCalculation)) {
                $this->propertiesRequiredForCalculation[] = 'standardinvestKrM2EllerKrM';
            }
        }

        return $this->propertiesRequiredForCalculation;
    }

    public function calculate()
    {
        $this->roerstoerrelseMmAekvivalent = $this->calculateRoerstoerrelseMmAekvivalent();
        $this->varmeledningsevnePaaEksistIsoleringWMK = $this->calculateVarmeledningsevnePaaEksistIsoleringWMK();
        $this->varmeledningsevnePaaNyIsoleringWMK = $this->calculateVarmeledningsevnePaaNyIsoleringWMK();
        $this->investeringKr = $this->calculateInvesteringKr();
        $this->eksistVarmetabKwh = $this->calculateEksistVarmetabKwh();
        $this->nytVarmetabKwh = $this->calculateNytVarmetabKwh();
        $this->varmebespKwhAar = $this->calculateVarmebespKwhAar();
        $this->kwhBesparelseElFraVaerket = $this->calculateKwhBesparelseElFraVaerket();
        $this->kwhBesparelseVarmeFraVaerket = $this->calculateKwhBesparelseVarmeFraVaerket();

        // Must come after both kwhBesparelseElFraVaerket and kwhBesparelseVarmeFraVaerket
        $this->simpelTilbagebetalingstidAar = $this->calculateSimpelTilbagebetalingstidAar();
        $this->nutidsvaerdiSetOver15AarKr = $this->calculateNutidsvaerdiSetOver15AarKr();
        parent::calculate();
    }

    private function calculateRoerstoerrelseMmAekvivalent()
    {
        return $this->udvDiameterMm;
    }

    private function calculateVarmeledningsevnePaaEksistIsoleringWMK()
    {
        return $this->getRapport()->getConfiguration()->getTekniskIsoleringVarmeledningsevneEksistLamelmaatter();
    }

    private function calculateVarmeledningsevnePaaNyIsoleringWMK()
    {
        return $this->getRapport()->getConfiguration()->getTekniskIsoleringVarmeledningsevneNyIsolering();
    }

    private function calculateInvesteringKr()
    {
        if ($this->overskrevetPris !== null) {
            return $this->overskrevetPris;
        }
        return $this->standardinvestKrM2EllerKrM * $this->prisfaktor * $this->roerlaengdeEllerHoejdeAfVvbM;
    }

    private function calculateEksistVarmetabKwh()
    {
        return $this->calculateEksisterendeUVaerdi() * $this->roerlaengdeEllerHoejdeAfVvbM * (abs($this->tempMedieC - $this->tempOmgivelC)) * $this->driftstidTAar / 1000 * $this->nyttiggjortVarme->getFaktor();
    }

    private function calculateNytVarmetabKwh()
    {
        return $this->calculateUkorrigeret() * $this->roerlaengdeEllerHoejdeAfVvbM * (abs($this->tempMedieC - $this->tempOmgivelC)) * $this->driftstidTAar / 1000 * $this->nyttiggjortVarme->getFaktor();
    }

    private function calculateVarmebespKwhAar()
    {
        // 'AE'
        try {
            return $this->eksistVarmetabKwh - $this->nytVarmetabKwh;
        } catch (\Exception $ex) {
            return 0;
        }
    }

    private function calculateKwhBesparelseElFraVaerket()
    {
        // 'AH'
        if ($this->varmebespKwhAar == 0) {
            return 0;
        } else if ($this->getRapport()->getStandardforsyning()) {
            return 0;
        } else {
            return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'EL');
        }
    }

    private function calculateKwhBesparelseVarmeFraVaerket()
    {
        // 'AI'
        if ($this->varmebespKwhAar == 0) {
            return 0;
        } else if ($this->getRapport()->getStandardforsyning()) {
            return $this->varmebespKwhAar;
        } else {
            return $this->fordelbesparelse($this->varmebespKwhAar, $this->tiltag->getForsyningVarme(), 'VARME');
        }
    }

    private function calculateSimpelTilbagebetalingstidAar()
    {
        // 'AF'
        if ($this->standardinvestKrM2EllerKrM > 0) {
            return $this->divide($this->investeringKr, $this->getRapport()->getElKrKWh() * $this->kwhBesparelseElFraVaerket + $this->getRapport()->getVarmeKrKWh() * $this->kwhBesparelseVarmeFraVaerket);
        } else {
            return 0;
        }
    }

    private function calculateNutidsvaerdiSetOver15AarKr()
    {
        if ($this->varmebespKwhAar == 0) {
            return 0;
        } else {
            return $this->nvPTO2($this->investeringKr, $this->kwhBesparelseVarmeFraVaerket, $this->kwhBesparelseElFraVaerket, 0, 0, 0, $this->tiltag->getLevetid(), 1, 0);
        }
    }

    /*
  "AJ": {
              "calculated": "=IF(OR(TekniskIsol20[[#This Row],[Driftstid (t/år)]]=\"\",TekniskIsol20[[#This Row],[Temp. omgivel. \n'[°C']]]=\"\",TekniskIsol20[[#This Row],[Temp. \nMedie \n'[°C']]]=\"\"),\"\",1*ABS(TekniskIsol20[[#This Row],[Temp. \nMedie \n'[°C']]]-TekniskIsol20[[#This Row],[Temp. omgivel. \n'[°C']]])*TekniskIsol20[[#This Row],[Driftstid (t/år)]]*3600)",
              "name": "Driftparameter  [°Cs/år]",
          },
    */

    /*
          "AK": {
              "calculated": "=IF(OR(TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]=\"\",TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]=0),\"\",\n2*((2*TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*TekniskIsol20[[#This Row],[Varmeledningsevne på eksist isolering '[W/m·K']]]*$AC$25*PI()/(((2*TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*LN(((2*TekniskIsol20[[#This Row],[Eksist. \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)/(TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000))*$AC$25+2*TekniskIsol20[[#This Row],[Varmeledningsevne på eksist isolering '[W/m·K']]]))",
              "name": "Eksisterende U-værdi "
          },
    */

    private function calculateEksisterendeUVaerdi()
    {
        // 'AK'
        if ($this->eksistIsolMm === null || $this->roerstoerrelseMmAekvivalent == 0) {
            return 0;
        } else {
            return $this->divide(
                (2 * ((2 * $this->eksistIsolMm / 1000) + $this->roerstoerrelseMmAekvivalent / 1000) * $this->varmeledningsevnePaaEksistIsoleringWMK * $this->getKonvektivVarmeovergangskoefficient() * PI()),
                (
                    ((2 * $this->eksistIsolMm / 1000) + $this->roerstoerrelseMmAekvivalent / 1000)
                    *
                    log($this->divide(((2 * $this->eksistIsolMm / 1000) + $this->roerstoerrelseMmAekvivalent / 1000), ($this->roerstoerrelseMmAekvivalent / 1000)))
                    *
                    $this->getKonvektivVarmeovergangskoefficient()
                    +
                    2 * $this->varmeledningsevnePaaEksistIsoleringWMK
                )
            );
        }
    }

    /*
          "AL": {
              "calculated": "=IF(OR(TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]=\"\",TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]=\"\",TekniskIsol20[[#This Row],[Varmeledningsevne på ny isolering '[W/m·K']]]=\"\"),\"\",2*((2*TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*TekniskIsol20[[#This Row],[Varmeledningsevne på ny isolering '[W/m·K']]]*$AC$25*PI()/(((2*TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)*LN(((2*TekniskIsol20[[#This Row],[Ny \nisol. \n'[mm']]]/1000)+TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000)/(TekniskIsol20[[#This Row],[Rørstørrelse '[mm'] ækvivalent]]/1000))*$AC$25+2*TekniskIsol20[[#This Row],[Varmeledningsevne på ny isolering '[W/m·K']]]))",
              "name": "Ukorrigeret "
    */
    private function calculateUkorrigeret()
    {
        // 'AL'
        if ($this->roerstoerrelseMmAekvivalent == 0 || $this->nyIsolMm == 0 || $this->varmeledningsevnePaaNyIsoleringWMK == 0) {
            return 0;
        } else {
            return 2 * ((2 * $this->nyIsolMm / 1000) + $this->roerstoerrelseMmAekvivalent / 1000) * $this->varmeledningsevnePaaNyIsoleringWMK * $this->getKonvektivVarmeovergangskoefficient() * PI() / (((2 * $this->nyIsolMm / 1000) + $this->roerstoerrelseMmAekvivalent / 1000) * log(((2 * $this->nyIsolMm / 1000) + $this->roerstoerrelseMmAekvivalent / 1000) / ($this->roerstoerrelseMmAekvivalent / 1000)) * $this->getKonvektivVarmeovergangskoefficient() + 2 * $this->varmeledningsevnePaaNyIsoleringWMK);
        }
    }

    private function getKonvektivVarmeovergangskoefficient()
    {
        // '$AC$25':
        return 9;
    }

    /**
     * Post load handler.
     *
     * @ORM\PostLoad
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $event
     */
    public function postLoad(LifecycleEventArgs $event) {
        $repository = $event->getEntityManager()
            ->getRepository('AppBundle:Configuration');
        $this->setConfiguration($repository->getConfiguration());
    }

}
