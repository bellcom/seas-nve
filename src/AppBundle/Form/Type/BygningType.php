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
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningType extends AbstractType {
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
      ->add('bygId')
      ->add('ident')
      ->add('enhedsys')
      ->add('enhedskode')
      ->add('type')
      ->add('kommentarer')
      ->add('adresse')
      ->add('postnummer')
      ->add('postBy')
      ->add('navn')
      ->add('ejer')
      ->add('afdelingsnavn')
      ->add('ejerA')
      ->add('anvendelse')
      ->add('bruttoetageareal')
      ->add('maalertype')
      ->add('vand')
      ->add('kundenummer')
      ->add('kode')
      ->add('varme')
      ->add('kundenr1')
      ->add('kode1')
      ->add('maalerskifteAFV')
      ->add('aFVInstnr1')
      ->add('el')
      ->add('instnr')
      ->add('kundenrNRGI')
      ->add('internetkode')
      ->add('aftagenr')
      ->add('telefon')
      ->add('divisionnavn')
      ->add('omraadenavn')
      ->add('kommune')
      ->add('ejerforhold')
      ->add('ansvarlig')
      ->add('magistrat')
      ->add('lokation')
      ->add('lokationsnavn')
      ->add('lederbetegnelse')
      ->add('ledersnavn')
      ->add('ledersmail')
      ->add('kontaktNotat')
      ->add('stamdataNotat')
      ->add('vandNotat')
      ->add('elNotat')
      ->add('varmeNotat')
      ->add('users');
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolverInterface $resolver
   *   @TODO: Missing description.
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Bygning'
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_bygning';
  }
}
