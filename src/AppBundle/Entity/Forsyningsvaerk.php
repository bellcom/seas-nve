<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// use Doctrine\ORM\Mapping\OneToMany;
// use Doctrine\ORM\Mapping\ManyToMany;
// use Doctrine\ORM\Mapping\JoinTable;
// use Doctrine\ORM\Mapping\OrderBy;
// use Doctrine\Common\Collections\ArrayCollection;
// use JMS\Serializer\Annotation as JMS;

/**
 * Forsyningsvaerk
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ForsyningsvaerkRepository")
 */
class Forsyningsvaerk {
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer", nullable=true)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="Navn", type="string", length=255, nullable=true)
   */
  private $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="Energiform", type="string", length=255, nullable=true)
   */
  private $energiform;

  /**
   * @var string
   *
   * @ORM\Column(name="Noter", type="text", nullable=true)
   */
  private $noter;

  /**
   * @var string
   *
   * @ORM\Column(name="NoterTBeregningAfRabat", type="text", nullable=true)
   */
  private $noterTBeregningAfRabat;

  /**
   * @var string
   *
   * @ORM\Column(name="vedForbrugOverKWh", type="text", nullable=true)
   */
  private $vedForbrugOverKWh;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2009", type="decimal", scale=2, nullable=true)
   */
  private $pris2009;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2014", type="decimal", scale=2, nullable=true)
   */
  private $pris2014;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2015", type="decimal", scale=2, nullable=true)
   */
  private $pris2015;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2016", type="decimal", scale=2, nullable=true)
   */
  private $pris2016;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2017", type="decimal", scale=2, nullable=true)
   */
  private $pris2017;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2018", type="decimal", scale=2, nullable=true)
   */
  private $pris2018;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2019", type="decimal", scale=2, nullable=true)
   */
  private $pris2019;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2020", type="decimal", scale=2, nullable=true)
   */
  private $pris2020;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2021", type="decimal", scale=2, nullable=true)
   */
  private $pris2021;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2022", type="decimal", scale=2, nullable=true)
   */
  private $pris2022;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2023", type="decimal", scale=2, nullable=true)
   */
  private $pris2023;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2024", type="decimal", scale=2, nullable=true)
   */
  private $pris2024;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2025", type="decimal", scale=2, nullable=true)
   */
  private $pris2025;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2026", type="decimal", scale=2, nullable=true)
   */
  private $pris2026;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2027", type="decimal", scale=2, nullable=true)
   */
  private $pris2027;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2028", type="decimal", scale=2, nullable=true)
   */
  private $pris2028;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2029", type="decimal", scale=2, nullable=true)
   */
  private $pris2029;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2030", type="decimal", scale=2, nullable=true)
   */
  private $pris2030;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2031", type="decimal", scale=2, nullable=true)
   */
  private $pris2031;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2032", type="decimal", scale=2, nullable=true)
   */
  private $pris2032;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2033", type="decimal", scale=2, nullable=true)
   */
  private $pris2033;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2034", type="decimal", scale=2, nullable=true)
   */
  private $pris2034;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2035", type="decimal", scale=2, nullable=true)
   */
  private $pris2035;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2036", type="decimal", scale=2, nullable=true)
   */
  private $pris2036;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2037", type="decimal", scale=2, nullable=true)
   */
  private $pris2037;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2038", type="decimal", scale=2, nullable=true)
   */
  private $pris2038;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2039", type="decimal", scale=2, nullable=true)
   */
  private $pris2039;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2040", type="decimal", scale=2, nullable=true)
   */
  private $pris2040;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2041", type="decimal", scale=2, nullable=true)
   */
  private $pris2041;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2042", type="decimal", scale=2, nullable=true)
   */
  private $pris2042;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2043", type="decimal", scale=2, nullable=true)
   */
  private $pris2043;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2044", type="decimal", scale=2, nullable=true)
   */
  private $pris2044;

  /**
   * @var float
   *
   * @ORM\Column(name="pris2045", type="decimal", scale=2, nullable=true)
   */
  private $pris2045;

  /**
   * @var float
   *
   * @ORM\Column(name="co2noter", type="text", nullable=true)
   */
  private $co2Noter;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2009", type="decimal", scale=2, nullable=true)
   */
  private $co2y2009;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2014", type="decimal", scale=2, nullable=true)
   */
  private $co2y2014;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2015", type="decimal", scale=2, nullable=true)
   */
  private $co2y2015;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2016", type="decimal", scale=2, nullable=true)
   */
  private $co2y2016;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2017", type="decimal", scale=2, nullable=true)
   */
  private $co2y2017;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2018", type="decimal", scale=2, nullable=true)
   */
  private $co2y2018;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2019", type="decimal", scale=2, nullable=true)
   */
  private $co2y2019;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2020", type="decimal", scale=2, nullable=true)
   */
  private $co2y2020;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2021", type="decimal", scale=2, nullable=true)
   */
  private $co2y2021;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2022", type="decimal", scale=2, nullable=true)
   */
  private $co2y2022;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2023", type="decimal", scale=2, nullable=true)
   */
  private $co2y2023;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2024", type="decimal", scale=2, nullable=true)
   */
  private $co2y2024;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2025", type="decimal", scale=2, nullable=true)
   */
  private $co2y2025;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2026", type="decimal", scale=2, nullable=true)
   */
  private $co2y2026;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2027", type="decimal", scale=2, nullable=true)
   */
  private $co2y2027;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2028", type="decimal", scale=2, nullable=true)
   */
  private $co2y2028;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2029", type="decimal", scale=2, nullable=true)
   */
  private $co2y2029;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2030", type="decimal", scale=2, nullable=true)
   */
  private $co2y2030;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2031", type="decimal", scale=2, nullable=true)
   */
  private $co2y2031;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2032", type="decimal", scale=2, nullable=true)
   */
  private $co2y2032;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2033", type="decimal", scale=2, nullable=true)
   */
  private $co2y2033;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2034", type="decimal", scale=2, nullable=true)
   */
  private $co2y2034;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2035", type="decimal", scale=2, nullable=true)
   */
  private $co2y2035;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2036", type="decimal", scale=2, nullable=true)
   */
  private $co2y2036;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2037", type="decimal", scale=2, nullable=true)
   */
  private $co2y2037;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2038", type="decimal", scale=2, nullable=true)
   */
  private $co2y2038;

  /**
   * @var float
   *
   * @ORM\Column(name="co2y2039", type="decimal", scale=2, nullable=true)
   */
  private $co2y2039;

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
   * Set pris2009.
   *
   * @param float $pris2009
   *   pris2009.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2009($pris2009) {
    $this->pris2009 = $pris2009;

    return $this;
  }

  /**
   * Get pris2009.
   *
   * @return float
   *   The pris2009.
   */
  public function getPris2009() {
    return $this->pris2009;
  }

  /**
   * Set pris2014.
   *
   * @param float $pris2014
   *   pris2014.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setPris2014($pris2014) {
    $this->pris2014 = $pris2014;

    return $this;
  }

  /**
   * Get pris2014.
   *
   * @return float
   *   The pris2014.
   */
  public function getPris2014() {
    return $this->pris2014;
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
   * Set co2ynoter.
   *
   * @param float $co2ynoter
   *   co2ynoter.
   *
   * @return Forsyningsvaerk
   *   This.
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
   * Set co2y2009.
   *
   * @param float $co2y2009
   *   co2y2009.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2009($co2y2009) {
    $this->co2y2009 = $co2y2009;

    return $this;
  }

  /**
   * Get co2y2009.
   *
   * @return float
   *   The co2y2009.
   */
  public function getCo2y2009() {
    return $this->co2y2009;
  }

  /**
   * Set co2y2014.
   *
   * @param float $co2y2014
   *   co2y2014.
   *
   * @return Forsyningsvaerk
   *   This.
   */
  public function setCo2y2014($co2y2014) {
    $this->co2y2014 = $co2y2014;

    return $this;
  }

  /**
   * Get co2y2014.
   *
   * @return float
   *   The co2y2014.
   */
  public function getCo2y2014() {
    return $this->co2y2014;
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
   * Return price in a given year. Defaults to the current year.
   *
   * @param int $year
   *   The year. Leave empty to use current year.
   *
   * @return float
   *   The rpice in the given year.
   */
  public function getKrKWh($year = NULL) {
    $property = 'pris' . ($year !== NULL ? $year : date('Y'));
    return isset($this->{$property}) ? $this->{$property} : 0;
  }

  public function getFaktor($startYear = NULL) {
    if ($startYear === NULL) {
      $startYear = date('Y');
    }
    $faktor = 0;
    for ($year = 0; $year < 15; $year++) {
      $faktor += $this->getKrKWh($startYear + $year);
    }
    return $faktor;
  }

}
