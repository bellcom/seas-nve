<?php
namespace AppBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use AppBundle\Entity\SpecialTiltagDetail;

class TiltagDetailTest extends KernelTestCase {
  public function testSetGetData() {
    $detail = new SpecialTiltagDetail();

    $data = array(__FILE__);

    $actual = $detail->setData('data', $data);

    $this->assertEquals($detail, $actual);

    $actual = $detail->getData('data');

    $this->assertEquals($data, $actual);
  }

}
