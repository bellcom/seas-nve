<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\BygningStatusRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningType extends AbstractType {

  private $doctrine;

  public function __construct(RegistryInterface $doctrine) {
    $this->doctrine = $doctrine;
  }

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
      ->add('navn')
      ->add('enhedsys')
      ->add('enhedskode')
      ->add('type')
      ->add('kommentarer')
      ->add('adresse')
      ->add('postnummer')
      ->add('postBy')
      ->add('ejer')
      ->add('afdelingsnavn')
      ->add('ejerA')
      ->add('anvendelse')
      ->add('bruttoetageareal')
      ->add('maalertype')
      ->add('kundenummer')
      ->add('kode')
      ->add('forsyningsvaerkVarme')
      ->add('kundenr1')
      ->add('kode1')
      ->add('maalerskifteAFV')
      ->add('aFVInstnr1')
      ->add('forsyningsvaerkEl')
      ->add('instnr')
      ->add('kundenrNRGI')
      ->add('internetkode')
      ->add('aftagenr')
      ->add('telefon')
      ->add('divisionnavn')
      ->add('omraadenavn')
      ->add('kommune')
      ->add('ejerforhold')
      ->add('magistrat')
      ->add('segment')
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
      ->add('forsyningsvaerkVand')
      ->add('status')
      ->add('aaplusAnsvarlig', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Aa+"),
        'required' => false,
        'empty_value'  => 'common.none',
      ))
      ->add('energiRaadgiver', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Rådgiver"),
        'required' => false,
        'empty_value'  => 'common.none',
      ));
      //->add('users', null, array('by_reference' => false, 'expanded' => true , 'multiple' => true));
  }

  private function getUsersFromGroup($groupname) {
    $em = $this->doctrine->getRepository('AppBundle:Group');

    $group = $em->findOneByName($groupname);

    return $group->getUsers();
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
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
