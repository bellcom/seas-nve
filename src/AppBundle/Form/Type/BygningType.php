<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Virksomhed;
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
  private $tilknutning;

  public function __construct(RegistryInterface $doctrine, AuthorizationChecker $authorizationChecker, $tilknutning = FALSE) {
    $this->doctrine = $doctrine;
    $this->authorizationChecker = $authorizationChecker;
    $this->tilknutning = $tilknutning;
  }

  /**
   * @inheritDoc
   */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $data = $builder->getData();
    $virksomheder = $this->doctrine->getRepository(Virksomhed::class)->findBy(array(), array('id' => 'desc'));
    foreach ($virksomheder as $virksomhed) {
      $virksomhederChoicesAttr[] = array('data-cvrnumber' => $virksomhed->getCvrNumber());
    }
    $virksomhedAttr = array('class' => 'cvr-search');
    if (!$this->tilknutning) {
        $virksomhedAttr['disabled'] = 'disabled';
    }
    $builder
      ->add('bygId')
      ->add('navn')
      ->add('virksomhed', 'entity', array(
          'class' => 'AppBundle:Virksomhed',
          'empty_value' => 'bygninger.strings.search_by_cvr',
          'choices' => $virksomheder,
          'choice_attr' => $virksomhederChoicesAttr,
          'choice_label' => function($virksomhed, $key, $index) {
              /** @var Virksomhed $virksomhed */
              return $virksomhed->getName() . ' (' . $virksomhed->getCvrNumber() . ')';
          },
          'required' => FALSE,
          'attr' => $virksomhedAttr,
      ))
      ->add('cvrNumber', 'hidden')
      ->add('eanNumber', null, $this->tilknutning ? array() : array('disabled' => 'disabled'))
      ->add('pNumber', null, $this->tilknutning ? array() : array('disabled' => 'disabled'))
      ->add('OpfoerselsAar')
      ->add('enhedsys')
      ->add('type')
      ->add('adresse')
      ->add('postnummer')
      ->add('postBy')
      ->add('afdelingsnavn')
      ->add('ejerA')
      ->add('anvendelse')
      ->add('bruttoetageareal')
      ->add('erhvervsareal')
      ->add('opvarmetareal')
      ->add('forsyningsvaerkVarme', 'entity', array(
        'class' => 'AppBundle:Forsyningsvaerk',
        'required' => FALSE,
        'empty_value' => '--',
      ))
      ->add('forsyningsvaerkEl', 'entity', array(
        'class' => 'AppBundle:Forsyningsvaerk',
        'required' => FALSE,
        'empty_value' => '--',
      ))
      ->add('divisionnavn')
      ->add('omraadenavn')
      ->add('ejerforhold')
      ->add('segment', 'entity', array(
        'class' => 'AppBundle:Segment',
        'required' => FALSE,
        'empty_value' => '--',
      ))
      ->add('aaplusAnsvarlig', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Administrator"),
        'required' => FALSE,
        'empty_value' => 'common.none',
      ))
      ->add('projektleder', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Projektleder"),
        'required' => FALSE,
        'empty_value' => 'common.none',
      ))
      ->add('energiRaadgiver', 'bootstrap_collection', array(
        'property_path' => 'energiRaadgiver',
        'type' => 'entity',
        'options' => array(
          'class' => 'AppBundle:User',
          'choices' => $this->getUsersFromGroup("Rådgiver"),
          'required' => FALSE,
          'empty_value' => '--',
        ),
        'allow_add' => true,
        'by_reference' => false,
        'allow_delete' => true,
        'add_button_text'    => 'Add more',
        'delete_button_text' => 'Delete',
        'sub_widget_col'     => 10,
        'button_col'         => 2
      ))
      ->add('projekterende', 'entity', array(
        'class' => 'AppBundle:User',
        'choices' => $this->getUsersFromGroup("Projekterende"),
        'required' => FALSE,
        'empty_value' => 'common.none',
      ))
      ->add('users', null, array(
        'expanded' => TRUE,
        'choices' => $this->getUsersFromGroup("Interessent"),
        ))
      ->add('contactPersons', 'bootstrap_collection', array(
        'property_path' => 'ContactPersons',
        'label' => FALSE,
        'type' => new ContactPersonEmbedType(),
        'required' => FALSE,
        'allow_add' => true,
        'by_reference' => false,
        'allow_delete' => true,
        'add_button_text'    => 'Add',
        'delete_button_text' => 'Delete',
        'sub_widget_col'     => 10,
        'button_col'         => 2
      ));
  }

  private function getUsersFromGroup($groupname) {
    $em = $this->doctrine->getRepository('AppBundle:Group');

    $group = $em->findOneByName($groupname);

    return empty($group) ? array(): $group->getUsers();
  }

  /**
   * @inheritDoc
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\Bygning',
    ));
  }

  /**
   * @inheritDoc.
   */
  public function getName() {
    return 'appbundle_bygning';
  }
}
