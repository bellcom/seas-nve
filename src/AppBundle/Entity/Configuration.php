<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\DBAL\Types\MonthType;
use AppBundle\DBAL\Types\VarmeanlaegTiltag\EnergiType;
use AppBundle\DBAL\Types\VarmeanlaegTiltag\VarmePumpeType;
use AppBundle\DBAL\Types\VentilationTiltagDetail\ForureningType;
use AppBundle\DBAL\Types\VentilationTiltagDetail\KvalitetType;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * Configuration
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ConfigurationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Configuration
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    protected $id;

    /**
     * @var float
     * @ORM\Column(name="rapport_kalkulationsrente", type="decimal", scale=4, nullable=true)
     */
    protected $rapportKalkulationsrente;

    /**
     * @var float
     * @ORM\Column(name="rapport_inflation", type="decimal", scale=4, nullable=true)
     */
    protected $rapportInflation;

    /**
     * @var float
     * @ORM\Column(name="rapport_lobetid", type="decimal", scale=4, nullable=true)
     */
    protected $rapportLobetid;

    /**
     * @var float
     * @ORM\Column(name="rapport_driftomkosningerfaktor", type="decimal", scale=4, nullable=true)
     */
    protected $rapportDriftomkostningerfaktor;

    /**
     * @var float
     * @ORM\Column(name="rapport_nominelEnergiprisstigning", type="decimal", scale=4, nullable=true)
     */
    protected $rapportNominelEnergiprisstigning;

    /**
     * @var float
     * @ORM\Column(name="rapport_procentAfInvestering", type="decimal", scale=4, nullable=true)
     */
    protected $rapportProcentAfInvestering = 0.1;

    /**
     * @var float
     * @ORM\Column(name="tekniskisolering_varmeledningsevneEksistLamelmaatter", type="decimal", scale=4, nullable=true)
     */
    protected $tekniskisoleringVarmeledningsevneEksistLamelmaatter;

    /**
     * @var float
     * @ORM\Column(name="tekniskisolering_varmeledningsevneNyIsolering", type="decimal", scale=4, nullable=true)
     */
    protected $tekniskisoleringVarmeledningsevneNyIsolering;

    /**
     * @var float
     * @ORM\Column(name="solcelletiltagdetail_energiprisstigningPctPrAar", type="decimal", scale=4, nullable=true)
     */
    protected $solcelletiltagdetailEnergiprisstigningPctPrAar;

    /**
     * @var float
     * @ORM\Column(name="solcelletiltagdetail_salgsprisFoerste10AarKrKWh", type="decimal", scale=4, nullable=true)
     */
    protected $solcelletiltagdetailSalgsprisFoerste10AarKrKWh;

    /**
     * @var float
     * @ORM\Column(name="solcelletiltagdetail_salgsprisEfter10AarKrKWh", type="decimal", scale=4, nullable=true)
     */
    protected $solcelletiltagdetailSalgsprisEfter10AarKrKWh;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=4, nullable=true)
     */
    protected $mtmFaellesomkostningerGrundpris = 5000;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=4, nullable=true)
     */
    protected $mtmFaellesomkostningerPrisPrM2 = 5.0000;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $mtmFaellesomkostningerNulHvisArealMindreEnd;

    /**
     * @var array
     *
     * @ORM\Column(name="tOpvarmningTimerAarMonthly", type="array")
     */
    protected $tOpvarmningTimerAarMonthly;

    /**
     * @var array
     *
     * @ORM\Column(name="tJordMonthly", type="array")
     */
    private $tJordMonthly;

    /**
     * @var array
     *
     * @ORM\Column(name="tUdeMonthly", type="array")
     */
    private $tUdeMonthly;

    /**
     * @var array
     *
     * @ORM\Column(name="grundventilationMatrix", type="array")
     */
    private $grundventilationMatrix;

    /**
     * @var array
     *
     * @ORM\Column(name="udeluftTilfoerselMatrix", type="array")
     */
    private $udeluftTilfoerselMatrix;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd;

    /**
     * @var array
     *
     * @ORM\Column(name="varmeEnergiFaktor", type="array")
     */
    private $varmeEnergiFaktor;

    /**
     * @var array
     *
     * @ORM\Column(name="varmePumpeFaktor", type="array")
     */
    private $varmePumpeFaktor;

    /**
     * @var integer
     *
     * @ORM\Column(name="nutidsvaerdiBeregnAar", type="decimal")
     */
    private $nutidsvaerdiBeregnAar = 25;

    /**
     * Constructor
     */
    public function __construct() {
        $this->setDefaultValues();
    }

    public function setDefaultValues() {
        if (empty($this->tUdeMonthly)) {
            $this->tUdeMonthly = array();
            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $this->tUdeMonthly[$key] = NULL;
            }
        }
        if (empty($this->tJordMonthly)) {
            $this->tJordMonthly = array();
            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $this->tJordMonthly[$key] = NULL;
            }
        }
        if (empty($this->tOpvarmningTimerAarMonthly)) {
            $this->tOpvarmningTimerAarMonthly = array();
            foreach (MonthType::getChoices() as $key => $value) {
                if (empty($key)) {
                    continue;
                }
                $this->tOpvarmningTimerAarMonthly[$key] = NULL;
            }
        }

        if (empty($this->udeluftTilfoerselMatrix)) {
            $this->setUdeluftTilfoerselMatrix(array(
                // Utilfredse personer i procent.
                // Static numbers from calculation file, cells K29 - M29
                // See xls/VentilationTiltagDetail/Ventilation2.xlsx
                'del_utilfredse_personer' => array(
                    KvalitetType::_1 => 0.15,
                    KvalitetType::_2 => 0.20,
                    KvalitetType::_3 => 0.30,
                ),
                // Personer (l/s pr. person).
                // Static numbers from calculation file, cells K30 - M30
                // See xls/VentilationTiltagDetail/Ventilation2.xlsx
                'lps_per_person' => array(
                    KvalitetType::_1 => 10,
                    KvalitetType::_2 => 7,
                    KvalitetType::_3 => 4,
                )
            ));
        }

        if (empty($this->grundventilationMatrix)) {
            // Static numbers from calculation file, cells L23 - N25
            // See xls/VentilationTiltagDetail/Ventilation2.xlsx
            $this->setGrundventilationMatrix(array(
                ForureningType::A => array(
                    KvalitetType::_1 => 0.5,
                    KvalitetType::_2 => 0.35,
                    KvalitetType::_3 => 0.3,
                ),
                ForureningType::B => array(
                    KvalitetType::_1 => 1,
                    KvalitetType::_2 => 0.7,
                    KvalitetType::_3 => 0.4,
                ),
                ForureningType::C => array(
                    KvalitetType::_1 => 1,
                    KvalitetType::_2 => 0.7,
                    KvalitetType::_3 => 0.4,
                ),
            ));
        }

        if (empty($this->varmeEnergiFaktor)) {
            // Static numbers from calculation file, cells L23 - N25
            // See xls/VarmePumpe/Bereging_af_armepumpe_redigeret_til_screeningsvaerktoej_V.1.xls
            $this->setVarmeEnergiFaktor(array(
                EnergiType::OLIE => 10,
                EnergiType::NATURGAS => 11,
                EnergiType::FJERMVARME => 1000,
                EnergiType::TRAEPILLER => 4.8,
                EnergiType::ELVARME => 1,
                EnergiType::VARMEPUMPE => 1,
            ));
        }

        if (empty($this->varmePumpeFaktor)) {
            // Static numbers from calculation file, cells P39 - P51
            // See xls/VarmePumpe/Bereging_af_armepumpe_redigeret_til_screeningsvaerktoej_V.1.xls
            $this->setVarmePumpeFaktor(array(
                VarmePumpeType::JORD_MED_GULV => 4.5,
                VarmePumpeType::JORD_MED_RADIATOR => 3.8,
                VarmePumpeType::LUFTVAND_MED_JORD => 3.9,
                VarmePumpeType::LUFTVAND_MED_RADIATOR => 3.3,
            ));
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRapportKalkulationsrente($kalkulationsrente)
    {
        $this->rapportKalkulationsrente = $kalkulationsrente;

        return $this;
    }

    public function getRapportKalkulationsrente()
    {
        return $this->rapportKalkulationsrente;
    }

    public function setRapportInflation($inflation)
    {
        $this->rapportInflation = $inflation;

        return $this;
    }

    public function getRapportInflation()
    {
        return $this->rapportInflation;
    }

    public function setRapportLobetid($lobetid)
    {
        $this->rapportLobetid = $lobetid;

        return $this;
    }

    public function getRapportLobetid()
    {
        return $this->rapportLobetid;
    }

    public function setRapportDriftomkostningerfaktor($faktor)
    {
        $this->rapportDriftomkostningerfaktor = $faktor;

        return $this;
    }

    public function getRapportDriftomkostningerfaktor()
    {
        return $this->rapportDriftomkostningerfaktor;
    }

    public function setRapportNominelEnergiprisstigning($rapport_nominelEnergiprisstigning)
    {
        $this->rapportNominelEnergiprisstigning = $rapport_nominelEnergiprisstigning;

        return $this;
    }

    public function getRapportNominelEnergiprisstigning()
    {
        return $this->rapportNominelEnergiprisstigning;
    }

    public function setRapportProcentAfInvestering($rapport_procentAfInvestering)
    {
        $this->rapportProcentAfInvestering = $rapport_procentAfInvestering;

        return $this;
    }

    public function getRapportProcentAfInvestering()
    {
        return $this->rapportProcentAfInvestering;
    }

    public function setTekniskIsoleringVarmeledningsevneEksistLamelmaatter($varmeledningsevneEksistLamelmaatter)
    {
        $this->tekniskisoleringVarmeledningsevneEksistLamelmaatter = $varmeledningsevneEksistLamelmaatter;

        return $this;
    }

    public function getTekniskIsoleringVarmeledningsevneEksistLamelmaatter()
    {
        return $this->tekniskisoleringVarmeledningsevneEksistLamelmaatter;
    }

    public function setTekniskIsoleringVarmeledningsevneNyIsolering($varmeledningsevneNyIsolering)
    {
        $this->tekniskisoleringVarmeledningsevneNyIsolering = $varmeledningsevneNyIsolering;

        return $this;
    }

    public function getTekniskIsoleringVarmeledningsevneNyIsolering()
    {
        return $this->tekniskisoleringVarmeledningsevneNyIsolering;
    }

    public function setSolcelletiltagdetailEnergiprisstigningPctPrAar($solcelletiltagdetailEnergiprisstigningPctPrAar)
    {
        $this->solcelletiltagdetailEnergiprisstigningPctPrAar = $solcelletiltagdetailEnergiprisstigningPctPrAar;

        return $this;
    }

    public function getSolcelletiltagdetailEnergiprisstigningPctPrAar()
    {
        return $this->solcelletiltagdetailEnergiprisstigningPctPrAar;
    }

    public function setSolcelletiltagdetailSalgsprisFoerste10AarKrKWh($solcelletiltagdetailSalgsprisFoerste10AarKrKWh)
    {
        $this->solcelletiltagdetailSalgsprisFoerste10AarKrKWh = $solcelletiltagdetailSalgsprisFoerste10AarKrKWh;

        return $this;
    }

    public function getSolcelletiltagdetailSalgsprisFoerste10AarKrKWh()
    {
        return $this->solcelletiltagdetailSalgsprisFoerste10AarKrKWh;
    }

    public function setSolcelletiltagdetailSalgsprisEfter10AarKrKWh($solcelletiltagdetailSalgsprisEfter10AarKrKWh)
    {
        $this->solcelletiltagdetailSalgsprisEfter10AarKrKWh = $solcelletiltagdetailSalgsprisEfter10AarKrKWh;

        return $this;
    }

    public function getSolcelletiltagdetailSalgsprisEfter10AarKrKWh()
    {
        return $this->solcelletiltagdetailSalgsprisEfter10AarKrKWh;
    }

    public function setMtmFaellesomkostningerGrundpris($mtmFaellesomkostningerGrundpris)
    {
        $this->mtmFaellesomkostningerGrundpris = $mtmFaellesomkostningerGrundpris;

        return $this;
    }

    public function getMtmFaellesomkostningerGrundpris()
    {
        return $this->mtmFaellesomkostningerGrundpris;
    }

    public function setMtmFaellesomkostningerPrisPrM2($mtmFaellesomkostningerPrisPrM2)
    {
        $this->mtmFaellesomkostningerPrisPrM2 = $mtmFaellesomkostningerPrisPrM2;

        return $this;
    }

    public function getMtmFaellesomkostningerPrisPrM2()
    {
        return $this->mtmFaellesomkostningerPrisPrM2;
    }

    public function setMtmFaellesomkostningerNulHvisArealMindreEnd($mtmFaellesomkostningerNulHvisArealMindreEnd)
    {
        $this->mtmFaellesomkostningerNulHvisArealMindreEnd = $mtmFaellesomkostningerNulHvisArealMindreEnd;

        return $this;
    }

    public function getMtmFaellesomkostningerNulHvisArealMindreEnd()
    {
        return $this->mtmFaellesomkostningerNulHvisArealMindreEnd;
    }

    public function setMtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd($mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd)
    {
        $this->mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd = $mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd;

        return $this;
    }

    public function getMtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd()
    {
        return $this->mtmFaellesomkostningerNulHvisTotalEntreprisesumMindreEnd;
    }

    /**
     * Set tOpvarmningTimerAarMonthly
     *
     * @param array $tOpvarmningTimerAarMonthly
     *
     * @return Configuration
     */
    public function setTOpvarmningTimerAarMonthly($tOpvarmningTimerAarMonthly)
    {
        $this->tOpvarmningTimerAarMonthly = $tOpvarmningTimerAarMonthly;
        return $this;
    }

    /**
     * Get tOpvarmningTimerAarMonthly
     *
     * @return array
     */
    public function getTOpvarmningTimerAarMonthly()
    {
        return $this->tOpvarmningTimerAarMonthly;
    }
    /**
     * Set tJordMonthly
     *
     * @param array $tJordMonthly
     *
     * @return Configuration
     */
    public function setTJordMonthly($tJordMonthly)
    {
        $this->tJordMonthly = $tJordMonthly;
        return $this;
    }

    /**
     * Get tJordMonthly
     *
     * @return array
     */
    public function getTJordMonthly()
    {
        return $this->tJordMonthly;
    }

    /**
     * Set tUdeMonthly
     *
     * @param array $tUdeMonthly
     *
     * @return Configuration
     */
    public function setTUdeMonthly($tUdeMonthly)
    {
        $this->tUdeMonthly = $tUdeMonthly;
        return $this;
    }

    /**
     * Get tUdeMonthly
     *
     * @return array
     */
    public function getTUdeMonthly()
    {
        return $this->tUdeMonthly;
    }

    /**
     * Set grundventilationMatrix
     *
     * @param array $grundventilationMatrix
     *
     * @return Configuration
     */
    public function setGrundventilationMatrix($grundventilationMatrix)
    {
        $this->grundventilationMatrix = $grundventilationMatrix;
        return $this;
    }

    /**
     * Get grundventilationMatrix
     *
     * @return array
     */
    public function getGrundventilationMatrix()
    {
        return $this->grundventilationMatrix;
    }

    /**
     * Set udeluftTilfoerselMatrix
     *
     * @param array $udeluftTilfoerselMatrix
     *
     * @return Configuration
     */
    public function setUdeluftTilfoerselMatrix($udeluftTilfoerselMatrix)
    {
        $this->udeluftTilfoerselMatrix = $udeluftTilfoerselMatrix;
        return $this;
    }

    /**
     * Get udeluftTilfoerselMatrix
     *
     * @return array
     */
    public function getUdeluftTilfoerselMatrix()
    {
        return $this->udeluftTilfoerselMatrix;
    }

    /**
     * Set varmeEnergiFaktor
     *
     * @param array $varmeEnergiFaktor
     *
     * @return Configuration
     */
    public function setVarmeEnergiFaktor($varmeEnergiFaktor)
    {
        $this->varmeEnergiFaktor = $varmeEnergiFaktor;
        return $this;
    }

    /**
     * Get varmeEnergiFaktor
     *
     * @return array
     */
    public function getVarmeEnergiFaktor()
    {
        return $this->varmeEnergiFaktor;
    }

    /**
     * Set varmePumpeFaktor
     *
     * @param array $varmePumpeFaktor
     *
     * @return Configuration
     */
    public function setVarmePumpeFaktor($varmePumpeFaktor)
    {
        $this->varmePumpeFaktor = $varmePumpeFaktor;
        return $this;
    }

    /**
     * Get varmePumpeFaktor
     *
     * @return array
     */
    public function getVarmePumpeFaktor()
    {
        return $this->varmePumpeFaktor;
    }

    /**
     * Set nutidsvaerdiBeregnAar
     *
     * @param integer $nutidsvaerdiBeregnAar
     *
     * @return Configuration
     */
    public function setNutidsvaerdiBeregnAar($nutidsvaerdiBeregnAar)
    {
        $this->nutidsvaerdiBeregnAar = $nutidsvaerdiBeregnAar;
        return $this;
    }

    /**
     * Get nutidsvaerdiBeregnAar
     *
     * @return integer
     */
    public function getNutidsvaerdiBeregnAar()
    {
        return empty($this->nutidsvaerdiBeregnAar) ? 25 : $this->nutidsvaerdiBeregnAar;
    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad() {
        $this->setDefaultValues();
    }

}
