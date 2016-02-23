<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\RegistryInterface;
use AppBundle\DBAL\Types\BygningStatusType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningType extends AbstractType {

  private $doctrine;
  private $authorizationChecker;

  public function __construct(RegistryInterface $doctrine, AuthorizationChecker $authorizationChecker) {
    $this->doctrine = $doctrine;
    $this->authorizationChecker = $authorizationChecker;
  }

  /**
   * @TODO: Missing description.
   *
   * @param FormBuilderInterface $builder
   * @TODO: Missing description.
   * @param array $options
   * @TODO: Missing description.
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
      ->add('bygId')
      ->add('ident')
      ->add('navn')
      ->add('OpfoerselsAar')
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
      ->add('forsyningsvaerkVarme', 'entity', array(
        'class' => 'AppBundle:Forsyningsvaerk',
        'required' => FALSE,
        'empty_value' => '--',
      ))
      ->add('kundenr1')
      ->add('kode1')
      ->add('maalerskifteAFV')
      ->add('aFVInstnr1')
      ->add('forsyningsvaerkEl', 'entity', array(
        'class' => 'AppBundle:Forsyningsvaerk',
        'required' => FALSE,
        'empty_value' => '--',
      ))
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
      ->add('segment', 'entity', array(
        'class' => 'AppBundle:Segment',
        'required' => FALSE,
        'empty_value' => '--',
      ))
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
      //->add('forsyningsvaerkVand')
      ->add('aaplusAnsvarlig', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Aa+"),
        'required' => FALSE,
        'empty_value' => 'common.none',
      ))
      ->add('energiRaadgiver', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Rådgiver"),
        'required' => FALSE,
        'empty_value' => 'common.none',
      ));

    // Only show the editable status field to super admins
    if ($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
      $builder->add('status');
    }
    else {
      $builder->add('status', 'hidden', array(
        'read_only' => TRUE
      ));
    }

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
   * @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Bygning',
      'validation_groups' => function (FormInterface $form) {
        $data = $form->getData();

        if (BygningStatusType::DATA_VERIFICERET == $data->getStatus()) {
          return array('Default', 'DATA_VERIFICERET');
        }
        else if (BygningStatusType::TILKNYTTET_RAADGIVER == $data->getStatus()) {
          return array('Default', 'TILKNYTTET_RAADGIVER');
        }

        return array('Default');
      },
    ));
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   * @TODO: Missing description.
   */
  public function getName() {
    return 'appbundle_bygning';
  }
}
