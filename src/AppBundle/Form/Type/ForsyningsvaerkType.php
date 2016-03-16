<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ForsyningsvaerkType extends AbstractType {
  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('navn')
      ->add('energiform')
      ->add('noter')
      ->add('noterTBeregningAfRabat')
      ->add('vedForbrugOverKWh')
      ->add('pris2009')
      ->add('pris2010')
      ->add('pris2011')
      ->add('pris2012')
      ->add('pris2013')
      ->add('pris2014')
      ->add('pris2015')
      ->add('pris2016')
      ->add('pris2017')
      ->add('pris2018')
      ->add('pris2019')
      ->add('pris2020')
      ->add('pris2021')
      ->add('pris2022')
      ->add('pris2023')
      ->add('pris2024')
      ->add('pris2025')
      ->add('pris2026')
      ->add('pris2027')
      ->add('pris2028')
      ->add('pris2029')
      ->add('pris2030')
      ->add('pris2031')
      ->add('pris2032')
      ->add('pris2033')
      ->add('pris2034')
      ->add('pris2035')
      ->add('pris2036')
      ->add('pris2037')
      ->add('pris2038')
      ->add('pris2039')
      ->add('pris2040')
      ->add('pris2041')
      ->add('pris2042')
      ->add('pris2043')
      ->add('pris2044')
      ->add('pris2045')
      ->add('pris2046')
      ->add('pris2047')
      ->add('pris2048')
      ->add('pris2049')
      ->add('pris2050')
      ->add('pris2051')
      ->add('pris2052')
      ->add('pris2053')
      ->add('pris2054')
      ->add('pris2055')
      ->add('pris2056')
      ->add('pris2057')
      ->add('pris2058')
      ->add('pris2059')
      ->add('pris2060')
      ->add('pris2061')
      ->add('pris2062')
      ->add('pris2063')
      ->add('pris2064')
      ->add('pris2065')
      ->add('pris2066')
      ->add('pris2067')
      ->add('pris2068')
      ->add('pris2069')
      ->add('pris2070')
      ->add('pris2071')
      ->add('pris2072')
      ->add('pris2073')
      ->add('pris2074')
      ->add('pris2075')
      ->add('co2Noter')
      ->add('co2y2009')
      ->add('co2y2010')
      ->add('co2y2011')
      ->add('co2y2012')
      ->add('co2y2013')
      ->add('co2y2014')
      ->add('co2y2015')
      ->add('co2y2016')
      ->add('co2y2017')
      ->add('co2y2018')
      ->add('co2y2019')
      ->add('co2y2020')
      ->add('co2y2021')
      ->add('co2y2022')
      ->add('co2y2023')
      ->add('co2y2024')
      ->add('co2y2025')
      ->add('co2y2026')
      ->add('co2y2027')
      ->add('co2y2028')
      ->add('co2y2029')
      ->add('co2y2030')
      ->add('co2y2031')
      ->add('co2y2032')
      ->add('co2y2033')
      ->add('co2y2034')
      ->add('co2y2035')
      ->add('co2y2036')
      ->add('co2y2037')
      ->add('co2y2038')
      ->add('co2y2039')
      ->add('co2y2040')
      ->add('co2y2041')
      ->add('co2y2042')
      ->add('co2y2043')
      ->add('co2y2044')
      ->add('co2y2045')
      ->add('co2y2046')
      ->add('co2y2047')
      ->add('co2y2048')
      ->add('co2y2049')
      ->add('co2y2050')
      ->add('co2y2051')
      ->add('co2y2052')
      ->add('co2y2053')
      ->add('co2y2054')
      ->add('co2y2055')
      ->add('co2y2056')
      ->add('co2y2057')
      ->add('co2y2058')
      ->add('co2y2059')
      ->add('co2y2060')
      ->add('co2y2061')
      ->add('co2y2062')
      ->add('co2y2063')
      ->add('co2y2064')
      ->add('co2y2065')
      ->add('co2y2066')
      ->add('co2y2067')
      ->add('co2y2068')
      ->add('co2y2069')
      ->add('co2y2070')
      ->add('co2y2071')
      ->add('co2y2072')
      ->add('co2y2073')
      ->add('co2y2074')
      ->add('co2y2075');
  }

  /**
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Forsyningsvaerk'
    ));
  }

  /**
   * @return string
   */
  public function getName() {
    return 'appbundle_forsyningsvaerk';
  }
}
