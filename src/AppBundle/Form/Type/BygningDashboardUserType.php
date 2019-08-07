<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Form\Type;

use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\DBAL\Types\BygningStatusType;
use AppBundle\Form\Type\BygningUdtraekType\SegmentUdtraekType;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class BygningType
 * @package AppBundle\Form
 */
class BygningDashboardUserType extends AbstractType {

  private $doctrine;
  private $userGroup;
  private $userGroupList;

  public function __construct(RegistryInterface $doctrine, $userGroup = null, array $userGroupList = null) {
    $this->doctrine = $doctrine;
    $this->userGroup = $userGroup;
    $this->userGroupList = $userGroupList;
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
    $choices = $this->userGroup ? $this->getUsersFromGroup($this->userGroup) : $this->getUsersFromGroupList($this->userGroupList);
    $builder->add('username', 'filter_choice', array('label' => false, 'choices' => $choices));
  }

  private function getUsersFromGroup($groupname) {
    $em = $this->doctrine->getRepository('AppBundle:Group');

    $group = $em->findOneByName($groupname);
    $result = array();

    if($group) {
      $users = empty($group) ? array(): $group->getUsers();

      foreach ($users as $user) {
        $result[$user->getUsername()] = $user->getUsername();
      }

      asort($result);
    }

    return $result;
  }

  private function getUsersFromGroupList(array $groups) {
    $result = array();
    foreach ($groups as $group) {
      foreach ($this->getUsersFromGroup($group) as  $user) {
        $result[$user] = $user;
      }
    }
    asort($result);

    return $result;
  }

  /**
   * @TODO: Missing description.
   *
   * @param OptionsResolver $resolver
   *   @TODO: Missing description.
   */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'AppBundle\Entity\User'
    ));
  }

  public function getParent()
  {
    return 'filter_sharedable'; // this allow us to use the "add_shared" option
  }

  /**
   * @TODO: Missing description.
   *
   * @return string
   *   @TODO: Missing description.
   */
  public function getName() {
    return 'dashboard_user';
  }
}
