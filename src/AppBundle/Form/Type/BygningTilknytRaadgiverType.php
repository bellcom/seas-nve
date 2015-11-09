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

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningTilknytRaadgiverType extends AbstractType {

  private $doctrine;

  public function __construct(RegistryInterface $doctrine) {
    $this->doctrine = $doctrine;
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
      ))
      ->add('status', 'hidden', array(
        'read_only' => TRUE
      ))
      ->add('rapport', new RapportEmbedType(), array(
          'by_reference' => TRUE,
          'data_class' => 'AppBundle\Entity\Rapport'
        )
      );
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
        else {
          if (BygningStatusType::TILKNYTTET_RAADGIVER == $data->getStatus()) {
            return array('Default', 'TILKNYTTET_RAADGIVER');
          }
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
