<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Configuration;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

/**
 * Forsyningsvaerk
 *
 * @ORM\Table()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ForsyningsvaerkRepository")
 */
class Forsyningsvaerk {
  use SoftDeleteableEntity;

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   *
   * @ORM\Column(name="Navn", type="string", length=255, nullable=true)
   */
  protected $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="Energiform", type="string", length=255, nullable=true)
   */
  protected $energiform;

  /**
   * @var string
   *
   * @ORM\Column(name="Noter", type="text", nullable=true)
   */
  protected $noter;

  /**
   * @var string
   *
   * @ORM\Column(name="NoterTBeregningAfRabat", type="text", nullable=true)
   */
  protected $noterTBeregningAfRabat;

  /**
   * @var string
   *
   * @ORM\Column(name="vedForbrugOverKWh", type="text", nullable=true)
   */
  protected $vedForbrugOverKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2009", type="decimal", scale=4, nullable=true)
   */
  protected $pris2009;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2010", type="decimal", scale=4, nullable=true)
   */
  protected $pris2010;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2011", type="decimal", scale=4, nullable=true)
   */
  protected $pris2011;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2012", type="decimal", scale=4, nullable=true)
   */
  protected $pris2012;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2013", type="decimal", scale=4, nullable=true)
   */
  protected $pris2013;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2014", type="decimal", scale=4, nullable=true)
   */
  protected $pris2014;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2015", type="decimal", scale=4, nullable=true)
   */
  protected $pris2015;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2016", type="decimal", scale=4, nullable=true)
   */
  protected $pris2016;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2017", type="decimal", scale=4, nullable=true)
   */
  protected $pris2017;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2018", type="decimal", scale=4, nullable=true)
   */
  protected $pris2018;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2019", type="decimal", scale=4, nullable=true)
   */
  protected $pris2019;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2020", type="decimal", scale=4, nullable=true)
   */
  protected $pris2020;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2021", type="decimal", scale=4, nullable=true)
   */
  protected $pris2021;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2022", type="decimal", scale=4, nullable=true)
   */
  protected $pris2022;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2023", type="decimal", scale=4, nullable=true)
   */
  protected $pris2023;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2024", type="decimal", scale=4, nullable=true)
   */
  protected $pris2024;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2025", type="decimal", scale=4, nullable=true)
   */
  protected $pris2025;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2026", type="decimal", scale=4, nullable=true)
   */
  protected $pris2026;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2027", type="decimal", scale=4, nullable=true)
   */
  protected $pris2027;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2028", type="decimal", scale=4, nullable=true)
   */
  protected $pris2028;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2029", type="decimal", scale=4, nullable=true)
   */
  protected $pris2029;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2030", type="decimal", scale=4, nullable=true)
   */
  protected $pris2030;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2031", type="decimal", scale=4, nullable=true)
   */
  protected $pris2031;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2032", type="decimal", scale=4, nullable=true)
   */
  protected $pris2032;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2033", type="decimal", scale=4, nullable=true)
   */
  protected $pris2033;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2034", type="decimal", scale=4, nullable=true)
   */
  protected $pris2034;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2035", type="decimal", scale=4, nullable=true)
   */
  protected $pris2035;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2036", type="decimal", scale=4, nullable=true)
   */
  protected $pris2036;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2037", type="decimal", scale=4, nullable=true)
   */
  protected $pris2037;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2038", type="decimal", scale=4, nullable=true)
   */
  protected $pris2038;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2039", type="decimal", scale=4, nullable=true)
   */
  protected $pris2039;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2040", type="decimal", scale=4, nullable=true)
   */
  protected $pris2040;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2041", type="decimal", scale=4, nullable=true)
   */
  protected $pris2041;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2042", type="decimal", scale=4, nullable=true)
   */
  protected $pris2042;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2043", type="decimal", scale=4, nullable=true)
   */
  protected $pris2043;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2044", type="decimal", scale=4, nullable=true)
   */
  protected $pris2044;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2045", type="decimal", scale=4, nullable=true)
   */
  protected $pris2045;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2046", type="decimal", scale=4, nullable=true)
   */
  protected $pris2046;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2047", type="decimal", scale=4, nullable=true)
   */
  protected $pris2047;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2048", type="decimal", scale=4, nullable=true)
   */
  protected $pris2048;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2049", type="decimal", scale=4, nullable=true)
   */
  protected $pris2049;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2050", type="decimal", scale=4, nullable=true)
   */
  protected $pris2050;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2051", type="decimal", scale=4, nullable=true)
   */
  protected $pris2051;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2052", type="decimal", scale=4, nullable=true)
   */
  protected $pris2052;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2053", type="decimal", scale=4, nullable=true)
   */
  protected $pris2053;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2054", type="decimal", scale=4, nullable=true)
   */
  protected $pris2054;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2055", type="decimal", scale=4, nullable=true)
   */
  protected $pris2055;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2056", type="decimal", scale=4, nullable=true)
   */
  protected $pris2056;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2057", type="decimal", scale=4, nullable=true)
   */
  protected $pris2057;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2058", type="decimal", scale=4, nullable=true)
   */
  protected $pris2058;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2059", type="decimal", scale=4, nullable=true)
   */
  protected $pris2059;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2060", type="decimal", scale=4, nullable=true)
   */
  protected $pris2060;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2061", type="decimal", scale=4, nullable=true)
   */
  protected $pris2061;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2062", type="decimal", scale=4, nullable=true)
   */
  protected $pris2062;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2063", type="decimal", scale=4, nullable=true)
   */
  protected $pris2063;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2064", type="decimal", scale=4, nullable=true)
   */
  protected $pris2064;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2065", type="decimal", scale=4, nullable=true)
   */
  protected $pris2065;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2066", type="decimal", scale=4, nullable=true)
   */
  protected $pris2066;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2067", type="decimal", scale=4, nullable=true)
   */
  protected $pris2067;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2068", type="decimal", scale=4, nullable=true)
   */
  protected $pris2068;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2069", type="decimal", scale=4, nullable=true)
   */
  protected $pris2069;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2070", type="decimal", scale=4, nullable=true)
   */
  protected $pris2070;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2071", type="decimal", scale=4, nullable=true)
   */
  protected $pris2071;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2072", type="decimal", scale=4, nullable=true)
   */
  protected $pris2072;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2073", type="decimal", scale=4, nullable=true)
   */
  protected $pris2073;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2074", type="decimal", scale=4, nullable=true)
   */
  protected $pris2074;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2075", type="decimal", scale=4, nullable=true)
   */
  protected $pris2075;

  /**
   * @var float
   *
   * @ORM\Column(name="co2noter", type="text", nullable=true)
   */
  protected $co2Noter;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2009", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2009;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2010", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2010;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2011", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2011;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2012", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2012;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2013", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2013;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2014", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2014;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2015", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2015;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2016", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2016;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2017", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2017;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2018", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2018;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2019", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2019;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2020", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2020;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2021", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2021;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2022", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2022;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2023", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2023;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2024", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2024;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2025", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2025;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2026", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2026;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2027", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2027;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2028", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2028;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2029", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2029;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2030", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2030;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2031", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2031;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2032", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2032;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2033", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2033;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2034", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2034;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2035", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2035;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2036", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2036;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2037", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2037;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2038", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2038;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2039", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2039;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2040", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2040;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2041", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2041;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2042", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2042;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2043", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2043;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2044", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2044;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2045", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2045;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2046", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2046;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2047", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2047;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2048", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2048;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2049", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2049;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2050", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2050;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2051", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2051;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2052", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2052;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2053", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2053;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2054", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2054;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2055", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2055;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2056", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2056;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2057", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2057;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2058", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2058;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2059", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2059;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2060", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2060;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2061", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2061;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2062", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2062;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2063", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2063;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2064", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2064;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2065", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2065;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2066", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2066;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2067", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2067;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2068", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2068;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2069", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2069;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2070", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2070;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2071", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2071;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2072", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2072;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2073", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2073;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2074", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2074;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2075", type="decimal", scale=4, nullable=true)
   */
  protected $co2y2075;

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->navn;
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
   * Set navn.
   *
   * @param string $navn
   *   navn.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setNavn($navn) {
    $this->navn = $navn;

    return $this;
  }

  /**
   * Get navn.
   *
   * @return string
   *   The navn.
   */
  public function getNavn() {
    return $this->navn;
  }

  /**
   * Set energiform.
   *
   * @param string $energiform
   *   energiform.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setEnergiform($energiform) {
    $this->energiform = $energiform;

    return $this;
  }

  /**
   * Get energiform.
   *
   * @return float
   *   The energiform.
   */
  public function getEnergiform() {
    return $this->energiform;
  }

  /**
   * Set noter.
   *
   * @param string $noter
   *   noter.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setNoter($noter) {
    $this->noter = $noter;

    return $this;
  }

  /**
   * Get noter.
   *
   * @return string
   *   The noter.
   */
  public function getNoter() {
    return $this->noter;
  }

  /**
   * Set noterTBeregningAfRabat.
   *
   * @param string $noterTBeregningAfRabat
   *   noterTBeregningAfRabat.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setNoterTBeregningAfRabat($noterTBeregningAfRabat) {
    $this->noterTBeregningAfRabat = $noterTBeregningAfRabat;

    return $this;
  }

  /**
   * Get noterTBeregningAfRabat.
   *
   * @return string
   *   The noterTBeregningAfRabat.
   */
  public function getNoterTBeregningAfRabat() {
    return $this->noterTBeregningAfRabat;
  }

  /**
   * Set vedForbrugOverKWh.
   *
   * @param float $vedForbrugOverKWh
   *   vedForbrugOverKWh.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setVedForbrugOverKWh($vedForbrugOverKWh) {
    $this->vedForbrugOverKWh = $vedForbrugOverKWh;

    return $this;
  }

  /**
   * Get vedForbrugOverKWh.
   *
   * @return float
   *   The vedForbrugOverKWh.
   */
  public function getVedForbrugOverKWh() {
    return $this->vedForbrugOverKWh;
  }

  /**
   * Set pris2015.
   *
   * @param float $pris2015
   *   pris2015.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2015($pris2015) {
    $this->pris2015 = $pris2015;

    return $this;
  }

  /**
   * Get pris2015.
   *
   * @return float
   *   The pris2015.
   */
  public function getPris2015() {
    return $this->pris2015;
  }

  /**
   * Set pris2016.
   *
   * @param float $pris2016
   *   pris2016.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2016($pris2016) {
    $this->pris2016 = $pris2016;

    return $this;
  }

  /**
   * Get pris2016.
   *
   * @return float
   *   The pris2016.
   */
  public function getPris2016() {
    return $this->pris2016;
  }

  /**
   * Set pris2017.
   *
   * @param float $pris2017
   *   pris2017.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2017($pris2017) {
    $this->pris2017 = $pris2017;

    return $this;
  }

  /**
   * Get pris2017.
   *
   * @return float
   *   The pris2017.
   */
  public function getPris2017() {
    return $this->pris2017;
  }

  /**
   * Set pris2018.
   *
   * @param float $pris2018
   *   pris2018.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2018($pris2018) {
    $this->pris2018 = $pris2018;

    return $this;
  }

  /**
   * Get pris2018.
   *
   * @return float
   *   The pris2018.
   */
  public function getPris2018() {
    return $this->pris2018;
  }

  /**
   * Set pris2019.
   *
   * @param float $pris2019
   *   pris2019.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2019($pris2019) {
    $this->pris2019 = $pris2019;

    return $this;
  }

  /**
   * Get pris2019.
   *
   * @return float
   *   The pris2019.
   */
  public function getPris2019() {
    return $this->pris2019;
  }

  /**
   * Set pris2020.
   *
   * @param float $pris2020
   *   pris2020.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2020($pris2020) {
    $this->pris2020 = $pris2020;

    return $this;
  }

  /**
   * Get pris2020.
   *
   * @return float
   *   The pris2020.
   */
  public function getPris2020() {
    return $this->pris2020;
  }

  /**
   * Set pris2021.
   *
   * @param float $pris2021
   *   pris2021.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2021($pris2021) {
    $this->pris2021 = $pris2021;

    return $this;
  }

  /**
   * Get pris2021.
   *
   * @return float
   *   The pris2021.
   */
  public function getPris2021() {
    return $this->pris2021;
  }

  /**
   * Set pris2022.
   *
   * @param float $pris2022
   *   pris2022.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2022($pris2022) {
    $this->pris2022 = $pris2022;

    return $this;
  }

  /**
   * Get pris2022.
   *
   * @return float
   *   The pris2022.
   */
  public function getPris2022() {
    return $this->pris2022;
  }

  /**
   * Set pris2023.
   *
   * @param float $pris2023
   *   pris2023.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2023($pris2023) {
    $this->pris2023 = $pris2023;

    return $this;
  }

  /**
   * Get pris2023.
   *
   * @return float
   *   The pris2023.
   */
  public function getPris2023() {
    return $this->pris2023;
  }

  /**
   * Set pris2024.
   *
   * @param float $pris2024
   *   pris2024.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2024($pris2024) {
    $this->pris2024 = $pris2024;

    return $this;
  }

  /**
   * Get pris2024.
   *
   * @return float
   *   The pris2024.
   */
  public function getPris2024() {
    return $this->pris2024;
  }

  /**
   * Set pris2025.
   *
   * @param float $pris2025
   *   pris2025.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2025($pris2025) {
    $this->pris2025 = $pris2025;

    return $this;
  }

  /**
   * Get pris2025.
   *
   * @return float
   *   The pris2025.
   */
  public function getPris2025() {
    return $this->pris2025;
  }

  /**
   * Set pris2026.
   *
   * @param float $pris2026
   *   pris2026.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2026($pris2026) {
    $this->pris2026 = $pris2026;

    return $this;
  }

  /**
   * Get pris2026.
   *
   * @return float
   *   The pris2026.
   */
  public function getPris2026() {
    return $this->pris2026;
  }

  /**
   * Set pris2027.
   *
   * @param float $pris2027
   *   pris2027.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2027($pris2027) {
    $this->pris2027 = $pris2027;

    return $this;
  }

  /**
   * Get pris2027.
   *
   * @return float
   *   The pris2027.
   */
  public function getPris2027() {
    return $this->pris2027;
  }

  /**
   * Set pris2028.
   *
   * @param float $pris2028
   *   pris2028.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2028($pris2028) {
    $this->pris2028 = $pris2028;

    return $this;
  }

  /**
   * Get pris2028.
   *
   * @return float
   *   The pris2028.
   */
  public function getPris2028() {
    return $this->pris2028;
  }

  /**
   * Set pris2029.
   *
   * @param float $pris2029
   *   pris2029.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2029($pris2029) {
    $this->pris2029 = $pris2029;

    return $this;
  }

  /**
   * Get pris2029.
   *
   * @return float
   *   The pris2029.
   */
  public function getPris2029() {
    return $this->pris2029;
  }

  /**
   * Set pris2030.
   *
   * @param float $pris2030
   *   pris2030.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2030($pris2030) {
    $this->pris2030 = $pris2030;

    return $this;
  }

  /**
   * Get pris2030.
   *
   * @return float
   *   The pris2030.
   */
  public function getPris2030() {
    return $this->pris2030;
  }

  /**
   * Set pris2031.
   *
   * @param float $pris2031
   *   pris2031.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2031($pris2031) {
    $this->pris2031 = $pris2031;

    return $this;
  }

  /**
   * Get pris2031.
   *
   * @return float
   *   The pris2031.
   */
  public function getPris2031() {
    return $this->pris2031;
  }

  /**
   * Set pris2032.
   *
   * @param float $pris2032
   *   pris2032.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2032($pris2032) {
    $this->pris2032 = $pris2032;

    return $this;
  }

  /**
   * Get pris2032.
   *
   * @return float
   *   The pris2032.
   */
  public function getPris2032() {
    return $this->pris2032;
  }

  /**
   * Set pris2033.
   *
   * @param float $pris2033
   *   pris2033.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2033($pris2033) {
    $this->pris2033 = $pris2033;

    return $this;
  }

  /**
   * Get pris2033.
   *
   * @return float
   *   The pris2033.
   */
  public function getPris2033() {
    return $this->pris2033;
  }

  /**
   * Set pris2034.
   *
   * @param float $pris2034
   *   pris2034.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2034($pris2034) {
    $this->pris2034 = $pris2034;

    return $this;
  }

  /**
   * Get pris2034.
   *
   * @return float
   *   The pris2034.
   */
  public function getPris2034() {
    return $this->pris2034;
  }

  /**
   * Set pris2035.
   *
   * @param float $pris2035
   *   pris2035.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2035($pris2035) {
    $this->pris2035 = $pris2035;

    return $this;
  }

  /**
   * Get pris2035.
   *
   * @return float
   *   The pris2035.
   */
  public function getPris2035() {
    return $this->pris2035;
  }

  /**
   * Set pris2036.
   *
   * @param float $pris2036
   *   pris2036.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2036($pris2036) {
    $this->pris2036 = $pris2036;

    return $this;
  }

  /**
   * Get pris2036.
   *
   * @return float
   *   The pris2036.
   */
  public function getPris2036() {
    return $this->pris2036;
  }

  /**
   * Set pris2037.
   *
   * @param float $pris2037
   *   pris2037.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2037($pris2037) {
    $this->pris2037 = $pris2037;

    return $this;
  }

  /**
   * Get pris2037.
   *
   * @return float
   *   The pris2037.
   */
  public function getPris2037() {
    return $this->pris2037;
  }

  /**
   * Set pris2038.
   *
   * @param float $pris2038
   *   pris2038.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2038($pris2038) {
    $this->pris2038 = $pris2038;

    return $this;
  }

  /**
   * Get pris2038.
   *
   * @return float
   *   The pris2038.
   */
  public function getPris2038() {
    return $this->pris2038;
  }

  /**
   * Set pris2039.
   *
   * @param float $pris2039
   *   pris2039.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2039($pris2039) {
    $this->pris2039 = $pris2039;

    return $this;
  }

  /**
   * Get pris2039.
   *
   * @return float
   *   The pris2039.
   */
  public function getPris2039() {
    return $this->pris2039;
  }

  /**
   * Set pris2040.
   *
   * @param float $pris2040
   *   pris2040.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2040($pris2040) {
    $this->pris2040 = $pris2040;

    return $this;
  }

  /**
   * Get pris2040.
   *
   * @return float
   *   The pris2040.
   */
  public function getPris2040() {
    return $this->pris2040;
  }

  /**
   * Set pris2041.
   *
   * @param float $pris2041
   *   pris2041.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2041($pris2041) {
    $this->pris2041 = $pris2041;

    return $this;
  }

  /**
   * Get pris2041.
   *
   * @return float
   *   The pris2041.
   */
  public function getPris2041() {
    return $this->pris2041;
  }

  /**
   * Set pris2042.
   *
   * @param float $pris2042
   *   pris2042.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2042($pris2042) {
    $this->pris2042 = $pris2042;

    return $this;
  }

  /**
   * Get pris2042.
   *
   * @return float
   *   The pris2042.
   */
  public function getPris2042() {
    return $this->pris2042;
  }

  /**
   * Set pris2043.
   *
   * @param float $pris2043
   *   pris2043.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2043($pris2043) {
    $this->pris2043 = $pris2043;

    return $this;
  }

  /**
   * Get pris2043.
   *
   * @return float
   *   The pris2043.
   */
  public function getPris2043() {
    return $this->pris2043;
  }

  /**
   * Set pris2044.
   *
   * @param float $pris2044
   *   pris2044.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2044($pris2044) {
    $this->pris2044 = $pris2044;

    return $this;
  }

  /**
   * Get pris2044.
   *
   * @return float
   *   The pris2044.
   */
  public function getPris2044() {
    return $this->pris2044;
  }

  /**
   * Set pris2045.
   *
   * @param float $pris2045
   *   pris2045.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2045($pris2045) {
    $this->pris2045 = $pris2045;

    return $this;
  }

  /**
   * Get pris2045.
   *
   * @return float
   *   The pris2045.
   */
  public function getPris2045() {
    return $this->pris2045;
  }

  /**
   * Set pris2046.
   *
   * @param float $pris2046
   *   pris2046.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2046($pris2046) {
    $this->pris2046 = $pris2046;

    return $this;
  }

  /**
   * Get pris2046.
   *
   * @return float
   *   The pris2046.
   */
  public function getPris2046() {
    return $this->pris2046;
  }

  /**
   * Set pris2047.
   *
   * @param float $pris2047
   *   pris2047.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2047($pris2047) {
    $this->pris2047 = $pris2047;

    return $this;
  }

  /**
   * Get pris2047.
   *
   * @return float
   *   The pris2047.
   */
  public function getPris2047() {
    return $this->pris2047;
  }

  /**
   * Set pris2048.
   *
   * @param float $pris2048
   *   pris2048.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2048($pris2048) {
    $this->pris2048 = $pris2048;

    return $this;
  }

  /**
   * Get pris2048.
   *
   * @return float
   *   The pris2048.
   */
  public function getPris2048() {
    return $this->pris2048;
  }

  /**
   * Set pris2049.
   *
   * @param float $pris2049
   *   pris2049.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2049($pris2049) {
    $this->pris2049 = $pris2049;

    return $this;
  }

  /**
   * Get pris2049.
   *
   * @return float
   *   The pris2049.
   */
  public function getPris2049() {
    return $this->pris2049;
  }

  /**
   * Set pris2050.
   *
   * @param float $pris2050
   *   pris2050.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2050($pris2050) {
    $this->pris2050 = $pris2050;

    return $this;
  }

  /**
   * Get pris2050.
   *
   * @return float
   *   The pris2050.
   */
  public function getPris2050() {
    return $this->pris2050;
  }

  /**
   * Set pris2051.
   *
   * @param float $pris2051
   *   pris2051.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2051($pris2051) {
    $this->pris2051 = $pris2051;

    return $this;
  }

  /**
   * Get pris2051.
   *
   * @return float
   *   The pris2051.
   */
  public function getPris2051() {
    return $this->pris2051;
  }

  /**
   * Set pris2052.
   *
   * @param float $pris2052
   *   pris2052.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2052($pris2052) {
    $this->pris2052 = $pris2052;

    return $this;
  }

  /**
   * Get pris2052.
   *
   * @return float
   *   The pris2052.
   */
  public function getPris2052() {
    return $this->pris2052;
  }

  /**
   * Set pris2053.
   *
   * @param float $pris2053
   *   pris2053.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2053($pris2053) {
    $this->pris2053 = $pris2053;

    return $this;
  }

  /**
   * Get pris2053.
   *
   * @return float
   *   The pris2053.
   */
  public function getPris2053() {
    return $this->pris2053;
  }

  /**
   * Set pris2054.
   *
   * @param float $pris2054
   *   pris2054.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2054($pris2054) {
    $this->pris2054 = $pris2054;

    return $this;
  }

  /**
   * Get pris2054.
   *
   * @return float
   *   The pris2054.
   */
  public function getPris2054() {
    return $this->pris2054;
  }

  /**
   * Set pris2055.
   *
   * @param float $pris2055
   *   pris2055.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2055($pris2055) {
    $this->pris2055 = $pris2055;

    return $this;
  }

  /**
   * Get pris2055.
   *
   * @return float
   *   The pris2055.
   */
  public function getPris2055() {
    return $this->pris2055;
  }

  /**
   * Set pris2056.
   *
   * @param float $pris2056
   *   pris2056.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2056($pris2056) {
    $this->pris2056 = $pris2056;

    return $this;
  }

  /**
   * Get pris2056.
   *
   * @return float
   *   The pris2056.
   */
  public function getPris2056() {
    return $this->pris2056;
  }

  /**
   * Set pris2057.
   *
   * @param float $pris2057
   *   pris2057.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2057($pris2057) {
    $this->pris2057 = $pris2057;

    return $this;
  }

  /**
   * Get pris2057.
   *
   * @return float
   *   The pris2057.
   */
  public function getPris2057() {
    return $this->pris2057;
  }

  /**
   * Set pris2058.
   *
   * @param float $pris2058
   *   pris2058.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2058($pris2058) {
    $this->pris2058 = $pris2058;

    return $this;
  }

  /**
   * Get pris2058.
   *
   * @return float
   *   The pris2058.
   */
  public function getPris2058() {
    return $this->pris2058;
  }

  /**
   * Set pris2059.
   *
   * @param float $pris2059
   *   pris2059.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2059($pris2059) {
    $this->pris2059 = $pris2059;

    return $this;
  }

  /**
   * Get pris2059.
   *
   * @return float
   *   The pris2059.
   */
  public function getPris2059() {
    return $this->pris2059;
  }

  /**
   * Set pris2060.
   *
   * @param float $pris2060
   *   pris2060.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2060($pris2060) {
    $this->pris2060 = $pris2060;

    return $this;
  }

  /**
   * Get pris2060.
   *
   * @return float
   *   The pris2060.
   */
  public function getPris2060() {
    return $this->pris2060;
  }

  /**
   * Set pris2061.
   *
   * @param float $pris2061
   *   pris2061.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2061($pris2061) {
    $this->pris2061 = $pris2061;

    return $this;
  }

  /**
   * Get pris2061.
   *
   * @return float
   *   The pris2061.
   */
  public function getPris2061() {
    return $this->pris2061;
  }

  /**
   * Set pris2062.
   *
   * @param float $pris2062
   *   pris2062.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2062($pris2062) {
    $this->pris2062 = $pris2062;

    return $this;
  }

  /**
   * Get pris2062.
   *
   * @return float
   *   The pris2062.
   */
  public function getPris2062() {
    return $this->pris2062;
  }

  /**
   * Set pris2063.
   *
   * @param float $pris2063
   *   pris2063.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2063($pris2063) {
    $this->pris2063 = $pris2063;

    return $this;
  }

  /**
   * Get pris2063.
   *
   * @return float
   *   The pris2063.
   */
  public function getPris2063() {
    return $this->pris2063;
  }

  /**
   * Set pris2064.
   *
   * @param float $pris2064
   *   pris2064.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2064($pris2064) {
    $this->pris2064 = $pris2064;

    return $this;
  }

  /**
   * Get pris2064.
   *
   * @return float
   *   The pris2064.
   */
  public function getPris2064() {
    return $this->pris2064;
  }

  /**
   * Set pris2065.
   *
   * @param float $pris2065
   *   pris2065.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2065($pris2065) {
    $this->pris2065 = $pris2065;

    return $this;
  }

  /**
   * Get pris2065.
   *
   * @return float
   *   The pris2065.
   */
  public function getPris2065() {
    return $this->pris2065;
  }

  /**
   * Set pris2066.
   *
   * @param float $pris2066
   *   pris2066.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2066($pris2066) {
    $this->pris2066 = $pris2066;

    return $this;
  }

  /**
   * Get pris2066.
   *
   * @return float
   *   The pris2066.
   */
  public function getPris2066() {
    return $this->pris2066;
  }

  /**
   * Set pris2067.
   *
   * @param float $pris2067
   *   pris2067.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2067($pris2067) {
    $this->pris2067 = $pris2067;

    return $this;
  }

  /**
   * Get pris2067.
   *
   * @return float
   *   The pris2067.
   */
  public function getPris2067() {
    return $this->pris2067;
  }

  /**
   * Set pris2068.
   *
   * @param float $pris2068
   *   pris2068.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2068($pris2068) {
    $this->pris2068 = $pris2068;

    return $this;
  }

  /**
   * Get pris2068.
   *
   * @return float
   *   The pris2068.
   */
  public function getPris2068() {
    return $this->pris2068;
  }

  /**
   * Set pris2069.
   *
   * @param float $pris2069
   *   pris2069.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2069($pris2069) {
    $this->pris2069 = $pris2069;

    return $this;
  }

  /**
   * Get pris2069.
   *
   * @return float
   *   The pris2069.
   */
  public function getPris2069() {
    return $this->pris2069;
  }

  /**
   * Set pris2070.
   *
   * @param float $pris2070
   *   pris2070.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2070($pris2070) {
    $this->pris2070 = $pris2070;

    return $this;
  }

  /**
   * Get pris2070.
   *
   * @return float
   *   The pris2070.
   */
  public function getPris2070() {
    return $this->pris2070;
  }

  /**
   * Set pris2071.
   *
   * @param float $pris2071
   *   pris2071.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2071($pris2071) {
    $this->pris2071 = $pris2071;

    return $this;
  }

  /**
   * Get pris2071.
   *
   * @return float
   *   The pris2071.
   */
  public function getPris2071() {
    return $this->pris2071;
  }

  /**
   * Set pris2072.
   *
   * @param float $pris2072
   *   pris2072.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2072($pris2072) {
    $this->pris2072 = $pris2072;

    return $this;
  }

  /**
   * Get pris2072.
   *
   * @return float
   *   The pris2072.
   */
  public function getPris2072() {
    return $this->pris2072;
  }

  /**
   * Set pris2073.
   *
   * @param float $pris2073
   *   pris2073.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2073($pris2073) {
    $this->pris2073 = $pris2073;

    return $this;
  }

  /**
   * Get pris2073.
   *
   * @return float
   *   The pris2073.
   */
  public function getPris2073() {
    return $this->pris2073;
  }

  /**
   * Set pris2074.
   *
   * @param float $pris2074
   *   pris2074.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2074($pris2074) {
    $this->pris2074 = $pris2074;

    return $this;
  }

  /**
   * Get pris2074.
   *
   * @return float
   *   The pris2074.
   */
  public function getPris2074() {
    return $this->pris2074;
  }

  /**
   * Set pris2075.
   *
   * @param float $pris2075
   *   pris2075.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2075($pris2075) {
    $this->pris2075 = $pris2075;

    return $this;
  }

  /**
   * Get pris2075.
   *
   * @return float
   *   The pris2075.
   */
  public function getPris2075() {
    return $this->pris2075;
  }

  /**
   * Set co2ynoter.
   *
   * @param $co2Noter
   * @return \AppBundle\Entity\Forsyningsvaerk This.
   * This.
   * @internal param float $co2ynoter co2ynoter.*   co2ynoter.
   *
   */
  public function setCo2Noter($co2Noter) {
    $this->co2Noter = $co2Noter;

    return $this;
  }

  /**
   * Get co2ynoter.
   *
   * @return float
   *   The co2ynoter.
   */
  public function getCo2Noter() {
    return $this->co2Noter;
  }

  /**
   * Set co2y2015.
   *
   * @param float $co2y2015
   *   co2y2015.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2015($co2y2015) {
    $this->co2y2015 = $co2y2015;

    return $this;
  }

  /**
   * Get co2y2015.
   *
   * @return float
   *   The co2y2015.
   */
  public function getCo2y2015() {
    return $this->co2y2015;
  }

  /**
   * Set co2y2016.
   *
   * @param float $co2y2016
   *   co2y2016.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2016($co2y2016) {
    $this->co2y2016 = $co2y2016;

    return $this;
  }

  /**
   * Get co2y2016.
   *
   * @return float
   *   The co2y2016.
   */
  public function getCo2y2016() {
    return $this->co2y2016;
  }

  /**
   * Set co2y2017.
   *
   * @param float $co2y2017
   *   co2y2017.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2017($co2y2017) {
    $this->co2y2017 = $co2y2017;

    return $this;
  }

  /**
   * Get co2y2017.
   *
   * @return float
   *   The co2y2017.
   */
  public function getCo2y2017() {
    return $this->co2y2017;
  }

  /**
   * Set co2y2018.
   *
   * @param float $co2y2018
   *   co2y2018.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2018($co2y2018) {
    $this->co2y2018 = $co2y2018;

    return $this;
  }

  /**
   * Get co2y2018.
   *
   * @return float
   *   The co2y2018.
   */
  public function getCo2y2018() {
    return $this->co2y2018;
  }

  /**
   * Set co2y2019.
   *
   * @param float $co2y2019
   *   co2y2019.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2019($co2y2019) {
    $this->co2y2019 = $co2y2019;

    return $this;
  }

  /**
   * Get co2y2019.
   *
   * @return float
   *   The co2y2019.
   */
  public function getCo2y2019() {
    return $this->co2y2019;
  }

  /**
   * Set co2y2020.
   *
   * @param float $co2y2020
   *   co2y2020.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2020($co2y2020) {
    $this->co2y2020 = $co2y2020;

    return $this;
  }

  /**
   * Get co2y2020.
   *
   * @return float
   *   The co2y2020.
   */
  public function getCo2y2020() {
    return $this->co2y2020;
  }

  /**
   * Set co2y2021.
   *
   * @param float $co2y2021
   *   co2y2021.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2021($co2y2021) {
    $this->co2y2021 = $co2y2021;

    return $this;
  }

  /**
   * Get co2y2021.
   *
   * @return float
   *   The co2y2021.
   */
  public function getCo2y2021() {
    return $this->co2y2021;
  }

  /**
   * Set co2y2022.
   *
   * @param float $co2y2022
   *   co2y2022.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2022($co2y2022) {
    $this->co2y2022 = $co2y2022;

    return $this;
  }

  /**
   * Get co2y2022.
   *
   * @return float
   *   The co2y2022.
   */
  public function getCo2y2022() {
    return $this->co2y2022;
  }

  /**
   * Set co2y2023.
   *
   * @param float $co2y2023
   *   co2y2023.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2023($co2y2023) {
    $this->co2y2023 = $co2y2023;

    return $this;
  }

  /**
   * Get co2y2023.
   *
   * @return float
   *   The co2y2023.
   */
  public function getCo2y2023() {
    return $this->co2y2023;
  }

  /**
   * Set co2y2024.
   *
   * @param float $co2y2024
   *   co2y2024.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2024($co2y2024) {
    $this->co2y2024 = $co2y2024;

    return $this;
  }

  /**
   * Get co2y2024.
   *
   * @return float
   *   The co2y2024.
   */
  public function getCo2y2024() {
    return $this->co2y2024;
  }

  /**
   * Set co2y2025.
   *
   * @param float $co2y2025
   *   co2y2025.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2025($co2y2025) {
    $this->co2y2025 = $co2y2025;

    return $this;
  }

  /**
   * Get co2y2025.
   *
   * @return float
   *   The co2y2025.
   */
  public function getCo2y2025() {
    return $this->co2y2025;
  }

  /**
   * Set co2y2026.
   *
   * @param float $co2y2026
   *   co2y2026.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2026($co2y2026) {
    $this->co2y2026 = $co2y2026;

    return $this;
  }

  /**
   * Get co2y2026.
   *
   * @return float
   *   The co2y2026.
   */
  public function getCo2y2026() {
    return $this->co2y2026;
  }

  /**
   * Set co2y2027.
   *
   * @param float $co2y2027
   *   co2y2027.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2027($co2y2027) {
    $this->co2y2027 = $co2y2027;

    return $this;
  }

  /**
   * Get co2y2027.
   *
   * @return float
   *   The co2y2027.
   */
  public function getCo2y2027() {
    return $this->co2y2027;
  }

  /**
   * Set co2y2028.
   *
   * @param float $co2y2028
   *   co2y2028.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2028($co2y2028) {
    $this->co2y2028 = $co2y2028;

    return $this;
  }

  /**
   * Get co2y2028.
   *
   * @return float
   *   The co2y2028.
   */
  public function getCo2y2028() {
    return $this->co2y2028;
  }

  /**
   * Set co2y2029.
   *
   * @param float $co2y2029
   *   co2y2029.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2029($co2y2029) {
    $this->co2y2029 = $co2y2029;

    return $this;
  }

  /**
   * Get co2y2029.
   *
   * @return float
   *   The co2y2029.
   */
  public function getCo2y2029() {
    return $this->co2y2029;
  }

  /**
   * Set co2y2030.
   *
   * @param float $co2y2030
   *   co2y2030.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2030($co2y2030) {
    $this->co2y2030 = $co2y2030;

    return $this;
  }

  /**
   * Get co2y2030.
   *
   * @return float
   *   The co2y2030.
   */
  public function getCo2y2030() {
    return $this->co2y2030;
  }

  /**
   * Set co2y2031.
   *
   * @param float $co2y2031
   *   co2y2031.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2031($co2y2031) {
    $this->co2y2031 = $co2y2031;

    return $this;
  }

  /**
   * Get co2y2031.
   *
   * @return float
   *   The co2y2031.
   */
  public function getCo2y2031() {
    return $this->co2y2031;
  }

  /**
   * Set co2y2032.
   *
   * @param float $co2y2032
   *   co2y2032.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2032($co2y2032) {
    $this->co2y2032 = $co2y2032;

    return $this;
  }

  /**
   * Get co2y2032.
   *
   * @return float
   *   The co2y2032.
   */
  public function getCo2y2032() {
    return $this->co2y2032;
  }

  /**
   * Set co2y2033.
   *
   * @param float $co2y2033
   *   co2y2033.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2033($co2y2033) {
    $this->co2y2033 = $co2y2033;

    return $this;
  }

  /**
   * Get co2y2033.
   *
   * @return float
   *   The co2y2033.
   */
  public function getCo2y2033() {
    return $this->co2y2033;
  }

  /**
   * Set co2y2034.
   *
   * @param float $co2y2034
   *   co2y2034.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2034($co2y2034) {
    $this->co2y2034 = $co2y2034;

    return $this;
  }

  /**
   * Get co2y2034.
   *
   * @return float
   *   The co2y2034.
   */
  public function getCo2y2034() {
    return $this->co2y2034;
  }

  /**
   * Set co2y2035.
   *
   * @param float $co2y2035
   *   co2y2035.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2035($co2y2035) {
    $this->co2y2035 = $co2y2035;

    return $this;
  }

  /**
   * Get co2y2035.
   *
   * @return float
   *   The co2y2035.
   */
  public function getCo2y2035() {
    return $this->co2y2035;
  }

  /**
   * Set co2y2036.
   *
   * @param float $co2y2036
   *   co2y2036.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2036($co2y2036) {
    $this->co2y2036 = $co2y2036;

    return $this;
  }

  /**
   * Get co2y2036.
   *
   * @return float
   *   The co2y2036.
   */
  public function getCo2y2036() {
    return $this->co2y2036;
  }

  /**
   * Set co2y2037.
   *
   * @param float $co2y2037
   *   co2y2037.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2037($co2y2037) {
    $this->co2y2037 = $co2y2037;

    return $this;
  }

  /**
   * Get co2y2037.
   *
   * @return float
   *   The co2y2037.
   */
  public function getCo2y2037() {
    return $this->co2y2037;
  }

  /**
   * Set co2y2038.
   *
   * @param float $co2y2038
   *   co2y2038.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2038($co2y2038) {
    $this->co2y2038 = $co2y2038;

    return $this;
  }

  /**
   * Get co2y2038.
   *
   * @return float
   *   The co2y2038.
   */
  public function getCo2y2038() {
    return $this->co2y2038;
  }

  /**
   * Set co2y2039.
   *
   * @param float $co2y2039
   *   co2y2039.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2039($co2y2039) {
    $this->co2y2039 = $co2y2039;

    return $this;
  }

  /**
   * Get co2y2039.
   *
   * @return float
   *   The co2y2039.
   */
  public function getCo2y2039() {
    return $this->co2y2039;
  }

  /**
   * Set co2y2040.
   *
   * @param float $co2y2040
   *   co2y2040.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2040($co2y2040) {
    $this->co2y2040 = $co2y2040;

    return $this;
  }

  /**
   * Get co2y2040.
   *
   * @return float
   *   The co2y2040.
   */
  public function getCo2y2040() {
    return $this->co2y2040;
  }

  /**
   * Set co2y2041.
   *
   * @param float $co2y2041
   *   co2y2041.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2041($co2y2041) {
    $this->co2y2041 = $co2y2041;

    return $this;
  }

  /**
   * Get co2y2041.
   *
   * @return float
   *   The co2y2041.
   */
  public function getCo2y2041() {
    return $this->co2y2041;
  }

  /**
   * Set co2y2042.
   *
   * @param float $co2y2042
   *   co2y2042.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2042($co2y2042) {
    $this->co2y2042 = $co2y2042;

    return $this;
  }

  /**
   * Get co2y2042.
   *
   * @return float
   *   The co2y2042.
   */
  public function getCo2y2042() {
    return $this->co2y2042;
  }

  /**
   * Set co2y2043.
   *
   * @param float $co2y2043
   *   co2y2043.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2043($co2y2043) {
    $this->co2y2043 = $co2y2043;

    return $this;
  }

  /**
   * Get co2y2043.
   *
   * @return float
   *   The co2y2043.
   */
  public function getCo2y2043() {
    return $this->co2y2043;
  }

  /**
   * Set co2y2044.
   *
   * @param float $co2y2044
   *   co2y2044.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2044($co2y2044) {
    $this->co2y2044 = $co2y2044;

    return $this;
  }

  /**
   * Get co2y2044.
   *
   * @return float
   *   The co2y2044.
   */
  public function getCo2y2044() {
    return $this->co2y2044;
  }

  /**
   * Set co2y2045.
   *
   * @param float $co2y2045
   *   co2y2045.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2045($co2y2045) {
    $this->co2y2045 = $co2y2045;

    return $this;
  }

  /**
   * Get co2y2045.
   *
   * @return float
   *   The co2y2045.
   */
  public function getCo2y2045() {
    return $this->co2y2045;
  }

  /**
   * Set co2y2046.
   *
   * @param float $co2y2046
   *   co2y2046.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2046($co2y2046) {
    $this->co2y2046 = $co2y2046;

    return $this;
  }

  /**
   * Get co2y2046.
   *
   * @return float
   *   The co2y2046.
   */
  public function getCo2y2046() {
    return $this->co2y2046;
  }

  /**
   * Set co2y2047.
   *
   * @param float $co2y2047
   *   co2y2047.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2047($co2y2047) {
    $this->co2y2047 = $co2y2047;

    return $this;
  }

  /**
   * Get co2y2047.
   *
   * @return float
   *   The co2y2047.
   */
  public function getCo2y2047() {
    return $this->co2y2047;
  }

  /**
   * Set co2y2048.
   *
   * @param float $co2y2048
   *   co2y2048.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2048($co2y2048) {
    $this->co2y2048 = $co2y2048;

    return $this;
  }

  /**
   * Get co2y2048.
   *
   * @return float
   *   The co2y2048.
   */
  public function getCo2y2048() {
    return $this->co2y2048;
  }

  /**
   * Set co2y2049.
   *
   * @param float $co2y2049
   *   co2y2049.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2049($co2y2049) {
    $this->co2y2049 = $co2y2049;

    return $this;
  }

  /**
   * Get co2y2049.
   *
   * @return float
   *   The co2y2049.
   */
  public function getCo2y2049() {
    return $this->co2y2049;
  }

  /**
   * Set co2y2050.
   *
   * @param float $co2y2050
   *   co2y2050.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2050($co2y2050) {
    $this->co2y2050 = $co2y2050;

    return $this;
  }

  /**
   * Get co2y2050.
   *
   * @return float
   *   The co2y2050.
   */
  public function getCo2y2050() {
    return $this->co2y2050;
  }

  /**
   * Set co2y2051.
   *
   * @param float $co2y2051
   *   co2y2051.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2051($co2y2051) {
    $this->co2y2051 = $co2y2051;

    return $this;
  }

  /**
   * Get co2y2051.
   *
   * @return float
   *   The co2y2051.
   */
  public function getCo2y2051() {
    return $this->co2y2051;
  }

  /**
   * Set co2y2052.
   *
   * @param float $co2y2052
   *   co2y2052.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2052($co2y2052) {
    $this->co2y2052 = $co2y2052;

    return $this;
  }

  /**
   * Get co2y2052.
   *
   * @return float
   *   The co2y2052.
   */
  public function getCo2y2052() {
    return $this->co2y2052;
  }

  /**
   * Set co2y2053.
   *
   * @param float $co2y2053
   *   co2y2053.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2053($co2y2053) {
    $this->co2y2053 = $co2y2053;

    return $this;
  }

  /**
   * Get co2y2053.
   *
   * @return float
   *   The co2y2053.
   */
  public function getCo2y2053() {
    return $this->co2y2053;
  }

  /**
   * Set co2y2054.
   *
   * @param float $co2y2054
   *   co2y2054.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2054($co2y2054) {
    $this->co2y2054 = $co2y2054;

    return $this;
  }

  /**
   * Get co2y2054.
   *
   * @return float
   *   The co2y2054.
   */
  public function getCo2y2054() {
    return $this->co2y2054;
  }

  /**
   * Set co2y2055.
   *
   * @param float $co2y2055
   *   co2y2055.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2055($co2y2055) {
    $this->co2y2055 = $co2y2055;

    return $this;
  }

  /**
   * Get co2y2055.
   *
   * @return float
   *   The co2y2055.
   */
  public function getCo2y2055() {
    return $this->co2y2055;
  }

  /**
   * Set co2y2056.
   *
   * @param float $co2y2056
   *   co2y2056.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2056($co2y2056) {
    $this->co2y2056 = $co2y2056;

    return $this;
  }

  /**
   * Get co2y2056.
   *
   * @return float
   *   The co2y2056.
   */
  public function getCo2y2056() {
    return $this->co2y2056;
  }

  /**
   * Set co2y2057.
   *
   * @param float $co2y2057
   *   co2y2057.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2057($co2y2057) {
    $this->co2y2057 = $co2y2057;

    return $this;
  }

  /**
   * Get co2y2057.
   *
   * @return float
   *   The co2y2057.
   */
  public function getCo2y2057() {
    return $this->co2y2057;
  }

  /**
   * Set co2y2058.
   *
   * @param float $co2y2058
   *   co2y2058.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2058($co2y2058) {
    $this->co2y2058 = $co2y2058;

    return $this;
  }

  /**
   * Get co2y2058.
   *
   * @return float
   *   The co2y2058.
   */
  public function getCo2y2058() {
    return $this->co2y2058;
  }

  /**
   * Set co2y2059.
   *
   * @param float $co2y2059
   *   co2y2059.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2059($co2y2059) {
    $this->co2y2059 = $co2y2059;

    return $this;
  }

  /**
   * Get co2y2059.
   *
   * @return float
   *   The co2y2059.
   */
  public function getCo2y2059() {
    return $this->co2y2059;
  }

  /**
   * Set co2y2060.
   *
   * @param float $co2y2060
   *   co2y2060.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2060($co2y2060) {
    $this->co2y2060 = $co2y2060;

    return $this;
  }

  /**
   * Get co2y2060.
   *
   * @return float
   *   The co2y2060.
   */
  public function getCo2y2060() {
    return $this->co2y2060;
  }

  /**
   * Set co2y2061.
   *
   * @param float $co2y2061
   *   co2y2061.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2061($co2y2061) {
    $this->co2y2061 = $co2y2061;

    return $this;
  }

  /**
   * Get co2y2061.
   *
   * @return float
   *   The co2y2061.
   */
  public function getCo2y2061() {
    return $this->co2y2061;
  }

  /**
   * Set co2y2062.
   *
   * @param float $co2y2062
   *   co2y2062.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2062($co2y2062) {
    $this->co2y2062 = $co2y2062;

    return $this;
  }

  /**
   * Get co2y2062.
   *
   * @return float
   *   The co2y2062.
   */
  public function getCo2y2062() {
    return $this->co2y2062;
  }

  /**
   * Set co2y2063.
   *
   * @param float $co2y2063
   *   co2y2063.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2063($co2y2063) {
    $this->co2y2063 = $co2y2063;

    return $this;
  }

  /**
   * Get co2y2063.
   *
   * @return float
   *   The co2y2063.
   */
  public function getCo2y2063() {
    return $this->co2y2063;
  }

  /**
   * Set co2y2064.
   *
   * @param float $co2y2064
   *   co2y2064.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2064($co2y2064) {
    $this->co2y2064 = $co2y2064;

    return $this;
  }

  /**
   * Get co2y2064.
   *
   * @return float
   *   The co2y2064.
   */
  public function getCo2y2064() {
    return $this->co2y2064;
  }

  /**
   * Set co2y2065.
   *
   * @param float $co2y2065
   *   co2y2065.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2065($co2y2065) {
    $this->co2y2065 = $co2y2065;

    return $this;
  }

  /**
   * Get co2y2065.
   *
   * @return float
   *   The co2y2065.
   */
  public function getCo2y2065() {
    return $this->co2y2065;
  }

  /**
   * Set co2y2066.
   *
   * @param float $co2y2066
   *   co2y2066.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2066($co2y2066) {
    $this->co2y2066 = $co2y2066;

    return $this;
  }

  /**
   * Get co2y2066.
   *
   * @return float
   *   The co2y2066.
   */
  public function getCo2y2066() {
    return $this->co2y2066;
  }

  /**
   * Set co2y2067.
   *
   * @param float $co2y2067
   *   co2y2067.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2067($co2y2067) {
    $this->co2y2067 = $co2y2067;

    return $this;
  }

  /**
   * Get co2y2067.
   *
   * @return float
   *   The co2y2067.
   */
  public function getCo2y2067() {
    return $this->co2y2067;
  }

  /**
   * Set co2y2068.
   *
   * @param float $co2y2068
   *   co2y2068.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2068($co2y2068) {
    $this->co2y2068 = $co2y2068;

    return $this;
  }

  /**
   * Get co2y2068.
   *
   * @return float
   *   The co2y2068.
   */
  public function getCo2y2068() {
    return $this->co2y2068;
  }

  /**
   * Set co2y2069.
   *
   * @param float $co2y2069
   *   co2y2069.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2069($co2y2069) {
    $this->co2y2069 = $co2y2069;

    return $this;
  }

  /**
   * Get co2y2069.
   *
   * @return float
   *   The co2y2069.
   */
  public function getCo2y2069() {
    return $this->co2y2069;
  }

  /**
   * Set co2y2070.
   *
   * @param float $co2y2070
   *   co2y2070.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2070($co2y2070) {
    $this->co2y2070 = $co2y2070;

    return $this;
  }

  /**
   * Get co2y2070.
   *
   * @return float
   *   The co2y2070.
   */
  public function getCo2y2070() {
    return $this->co2y2070;
  }

  /**
   * Set co2y2071.
   *
   * @param float $co2y2071
   *   co2y2071.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2071($co2y2071) {
    $this->co2y2071 = $co2y2071;

    return $this;
  }

  /**
   * Get co2y2071.
   *
   * @return float
   *   The co2y2071.
   */
  public function getCo2y2071() {
    return $this->co2y2071;
  }

  /**
   * Set co2y2072.
   *
   * @param float $co2y2072
   *   co2y2072.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2072($co2y2072) {
    $this->co2y2072 = $co2y2072;

    return $this;
  }

  /**
   * Get co2y2072.
   *
   * @return float
   *   The co2y2072.
   */
  public function getCo2y2072() {
    return $this->co2y2072;
  }

  /**
   * Set co2y2073.
   *
   * @param float $co2y2073
   *   co2y2073.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2073($co2y2073) {
    $this->co2y2073 = $co2y2073;

    return $this;
  }

  /**
   * Get co2y2073.
   *
   * @return float
   *   The co2y2073.
   */
  public function getCo2y2073() {
    return $this->co2y2073;
  }

  /**
   * Set co2y2074.
   *
   * @param float $co2y2074
   *   co2y2074.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2074($co2y2074) {
    $this->co2y2074 = $co2y2074;

    return $this;
  }

  /**
   * Get co2y2074.
   *
   * @return float
   *   The co2y2074.
   */
  public function getCo2y2074() {
    return $this->co2y2074;
  }

  /**
   * Set co2y2075.
   *
   * @param float $co2y2075
   *   co2y2075.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2075($co2y2075) {
    $this->co2y2075 = $co2y2075;

    return $this;
  }

  /**
   * Get co2y2075.
   *
   * @return float
   *   The co2y2075.
   */
  public function getCo2y2075() {
    return $this->co2y2075;
  }

  /**
   * @return float
   */
  public function getPris2009() {
    return $this->pris2009;
  }

  /**
   * @param float $pris2009
   */
  public function setPris2009($pris2009) {
    $this->pris2009 = $pris2009;
  }

  /**
   * @return float
   */
  public function getPris2010() {
    return $this->pris2010;
  }

  /**
   * @param float $pris2010
   */
  public function setPris2010($pris2010) {
    $this->pris2010 = $pris2010;
  }

  /**
   * @return float
   */
  public function getPris2011() {
    return $this->pris2011;
  }

  /**
   * @param float $pris2011
   */
  public function setPris2011($pris2011) {
    $this->pris2011 = $pris2011;
  }

  /**
   * @return float
   */
  public function getPris2012() {
    return $this->pris2012;
  }

  /**
   * @param float $pris2012
   */
  public function setPris2012($pris2012) {
    $this->pris2012 = $pris2012;
  }

  /**
   * @return float
   */
  public function getPris2013() {
    return $this->pris2013;
  }

  /**
   * @param float $pris2013
   */
  public function setPris2013($pris2013) {
    $this->pris2013 = $pris2013;
  }

  /**
   * @return float
   */
  public function getPris2014() {
    return $this->pris2014;
  }

  /**
   * @param float $pris2014
   */
  public function setPris2014($pris2014) {
    $this->pris2014 = $pris2014;
  }

  /**
   * @return float
   */
  public function getCo2y2009() {
    return $this->co2y2009;
  }

  /**
   * @param float $co2y2009
   */
  public function setCo2y2009($co2y2009) {
    $this->co2y2009 = $co2y2009;
  }

  /**
   * @return float
   */
  public function getCo2y2010() {
    return $this->co2y2010;
  }

  /**
   * @param float $co2y2010
   */
  public function setCo2y2010($co2y2010) {
    $this->co2y2010 = $co2y2010;
  }

  /**
   * @return float
   */
  public function getCo2y2011() {
    return $this->co2y2011;
  }

  /**
   * @param float $co2y2011
   */
  public function setCo2y2011($co2y2011) {
    $this->co2y2011 = $co2y2011;
  }

  /**
   * @return float
   */
  public function getCo2y2012() {
    return $this->co2y2012;
  }

  /**
   * @param float $co2y2012
   */
  public function setCo2y2012($co2y2012) {
    $this->co2y2012 = $co2y2012;
  }

  /**
   * @return float
   */
  public function getCo2y2013() {
    return $this->co2y2013;
  }

  /**
   * @param float $co2y2013
   */
  public function setCo2y2013($co2y2013) {
    $this->co2y2013 = $co2y2013;
  }

  /**
   * @return float
   */
  public function getCo2y2014() {
    return $this->co2y2014;
  }

  /**
   * @param float $co2y2014
   */
  public function setCo2y2014($co2y2014) {
    $this->co2y2014 = $co2y2014;
  }


  /**
   * Return price in a given year. Defaults to the current year.
   *
   * @param int $year
   *   The year. Leave empty to use current year.
   *
   * @return float
   *   The price in the given year.
   */
  public function getKrKWh($year) {
    $property = 'pris' . $year;
    return isset($this->{$property}) ? $this->{$property} : 0;
  }

  /**
   * Return co2 stuff in a given year. Defaults to the current year.
   *
   * @param int $year
   *   The year. Leave empty to use current year.
   *
   * @return float
   *   The price in the given year.
   */
  public function getKgCo2MWh($year) {
    $property = 'co2y' . $year;
    return isset($this->{$property}) ? $this->{$property} : 0;
  }

  public function getFaktor(Configuration $configuration, $startYear = NULL) {
    $numberOfYears = 15;

    if ($startYear === NULL) {
      $startYear = date('Y');
    }

    $faktor = 0;
    for ($year = 1; $year <= $numberOfYears; $year++) {
      $faktor += $this->getKrKWh($startYear + $year - 1) / pow(1 + $configuration->getRapportKalkulationsrente(), $year);
    }
    return $faktor;
  }

}
