<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TiltagType
 * @package AppBundle\Form
 */
class TiltagType extends AbstractType {
  /**
   * @TODO: Missing description.
   *
   * @param FormBuilderInterface $builder
   *   @TODO: Missing description.
   * @param array $options
   *   @TODO: Missing description.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('title')
      ->add('varmebsparelseGUF')
      ->add('varmebesparelseGAF')
      ->add('elbesparelse')
      ->add('vandbesparelse')
      ->add('energibesparelseAarEt')
      ->add('co2besparelseAarEt')
      ->add('antalReinvesteringer')
      ->add('faktor')
      ->add('primaerEnterprise')
      ->add('tilbudskategori')
      ->add('anlaegsInvestering')
      ->add('dVBesparelse')
      ->add('levetid')
      ->add('forsyningVarme')
      ->add('el')
      ->add('beskrivelseNevaerende')
      ->add('beskrivelseForslag')
      ->add('beskrivelseOevrige')
      ->add('risikovurdering')
      ->add('placering')
      ->add('beskrivelseBV')
      ->add('indeklima')
      ->add('rapport');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Tiltag'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_tiltag';
  }
}
