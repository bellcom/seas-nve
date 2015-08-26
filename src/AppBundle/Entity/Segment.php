<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Segment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SegmentRepository")
 */
class Segment
{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(name="Navn", type="string", length=255)
   */
  private $navn;

  /**
   * @var string
   *
   * @ORM\Column(name="Forkortelse", type="string", length=5)
   */
  private $forkortelse;

  /**
   * @var string
   *
   * @ORM\Column(name="Magistrat", type="string", length=255)
   */
  private $magistrat;

  /**
   * @OneToMany(targetEntity="Bygning", mappedBy="segment")
   **/
  protected $bygninger;

  /**
   * @ManyToOne(targetEntity="User", inversedBy="segmenter", fetch="EAGER")
   * @JoinColumn(name="user_id", referencedColumnName="id")
   **/
  protected $segmentAnsvarlig;


  public function __construct() {
    $this->bygninger = new ArrayCollection();
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
   * Set navn
   *
   * @param string $navn
   *
   * @return Segment
   */
  public function setNavn($navn)
  {
    $this->navn = $navn;

    return $this;
  }

  /**
   * Get navn
   *
   * @return string
   */
  public function getNavn()
  {
    return $this->navn;
  }

  /**
   * Set forkortelse
   *
   * @param string $forkortelse
   *
   * @return Segment
   */
  public function setForkortelse($forkortelse)
  {
    $this->forkortelse = $forkortelse;

    return $this;
  }

  /**
   * Get forkortelse
   *
   * @return string
   */
  public function getForkortelse()
  {
    return $this->forkortelse;
  }

  /**
   * Set magistrat
   *
   * @param string $magistrat
   *
   * @return Segment
   */
  public function setMagistrat($magistrat)
  {
    $this->magistrat = $magistrat;

    return $this;
  }

  /**
   * Get magistrat
   *
   * @return string
   */
  public function getMagistrat()
  {
    return $this->magistrat;
  }

  /**
   * Get Name
   *
   * @return string
   */
  public function __toString() {
    return $this->getForkortelse()." - ".$this->getNavn();
  }


  /**
   * Add bygninger
   *
   * @param \AppBundle\Entity\Bygning $bygninger
   *
   * @return Segment
   */
  public function addBygninger(\AppBundle\Entity\Bygning $bygninger)
  {
    $this->bygninger[] = $bygninger;

    return $this;
  }

  /**
   * Remove bygninger
   *
   * @param \AppBundle\Entity\Bygning $bygninger
   */
  public function removeBygninger(\AppBundle\Entity\Bygning $bygninger)
  {
    $this->bygninger->removeElement($bygninger);
  }

  /**
   * Get bygninger
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getBygninger()
  {
    return $this->bygninger;
  }

    /**
     * Set segmentAnsvarlig
     *
     * @param \AppBundle\Entity\User $segmentAnsvarlig
     *
     * @return Segment
     */
    public function setSegmentAnsvarlig(\AppBundle\Entity\User $segmentAnsvarlig = null)
    {
        $this->segmentAnsvarlig = $segmentAnsvarlig;

        return $this;
    }

    /**
     * Get segmentAnsvarlig
     *
     * @return \AppBundle\Entity\User
     */
    public function getSegmentAnsvarlig()
    {
        return $this->segmentAnsvarlig;
    }
}
