<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Segment;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Collections\ArrayCollection;
use Ddeboer\DataImport\Writer\CallbackWriter;

use AppBundle\Entity\TiltagsKategori;

/**
 * Class LoadTiltagsKategoriData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadTiltagsKategoriData extends LoadData {
  protected $order = 3;
  protected $flush = true;

  protected function createWriter(ObjectManager $manager) {
    return new CallbackWriter(function($item) use ($manager) {
      $kategori = new TiltagsKategori();

      $kategori->setNavn($item['navn']);
      $manager->persist($kategori);
    });
  }
}
