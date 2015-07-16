<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Regning;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Energiforsyning;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Energiforsyning controller.
 *
 * @Route("/energiforsyning")
 */
class EnergiforsyningController extends Controller implements InitControllerInterface {

  protected $breadcrumbs;

  public function init(Request $request)
  {
    $this->breadcrumbs = $this->get('white_october_breadcrumbs');
    $this->breadcrumbs->addItem('Dashboard', $this->get('router')->generate('dashboard'));
    $this->breadcrumbs->addItem('Bygninger', $this->get('router')->generate('bygning'));
  }

  // /**
  //  * Lists all Energiforsyning entities.
  //  *
  //  * @Route("/", name="energiforsyning")
  //  * @Method("GET")
  //  * @Template()
  //  */
  // public function indexAction() {
  //   $em = $this->getDoctrine()->getManager();

  //   $entities = $em->getRepository('AppBundle:Energiforsyning')->findAll();

  //   return array(
  //     'entities' => $entities,
  //   );
  // }

  /**
   * Finds and displays a Energiforsyning entity.
   *
   * @Route("/{id}", name="energiforsyning_show")
   * @Method("GET")
   * @Template()
   * @param Energiforsyning $entity
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Energiforsyning $entity) {
    $this->breadcrumbs->addItem($entity->getRapport()->getBygning(), $this->get('router')->generate('bygning_show', array('id' => $entity->getRapport()->getBygning()->getId())));
    $this->breadcrumbs->addItem($entity->getRapport()->getVersion(), $this->get('router')->generate('rapport_show', array('id' => $entity->getRapport()->getId())));
    $this->breadcrumbs->addItem($entity->getTitle(), $this->get('router')->generate('rapport_show', array('id' => $entity->getRapport()->getId())));

    $deleteForm = $this->createDeleteForm($entity);
    $form = $this->createDetailCreateForm($entity);
    $editForm = $this->createEditForm($entity);

    $template = $this->getTemplate($entity, 'show');
    return $this->render($template, array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
      'create_detail_form' => $form->createView(),
      'edit_form' => $editForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing Energiforsyning entity.
   *
   * @Route("/{id}/edit", name="energiforsyning_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Energiforsyning $entity) {
    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($entity);

    $template = $this->getTemplate($entity, 'edit');
    return $this->render($template, array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Creates a form to edit a Energiforsyning entity.
   *
   * @param Energiforsyning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Energiforsyning $entity) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className(), $entity, array(
      'action' => $this->generateUrl('energiforsyning_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing Energiforsyning entity.
   *
   * @Route("/{id}", name="energiforsyning_update")
   * @Method("PUT")
   * @Template("AppBundle:Energiforsyning:edit.html.twig")
   */
  public function updateAction(Request $request, Energiforsyning $entity) {
    $deleteForm = $this->createDeleteForm($entity);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('energiforsyning_edit', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Energiforsyning entity.
   *
   * @Route("/{id}", name="energiforsyning_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Energiforsyning $entity) {
    $form = $this->createDeleteForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('energiforsyning'));
  }

  /**
   * Creates a form to delete a Energiforsyning entity
   *
   * @param Energiforsyning $entity
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Energiforsyning $entity) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('energiforsyning_delete', array('id' => $entity->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Displays a form to create a new Energiforsyning entity.
   *
   * @Route("/new/{type}", name="energiforsyning_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction($type) {
    $entity = $this->createEnergiforsyning($type);
    $form = $this->createCreateForm($entity, $type);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a new Energiforsyning entity.
   *
   * @Route("/new/{type}", name="energiforsyning_create")
   * @Method("POST")
   * @Template("AppBundle:Energiforsyning:new.html.twig")
   */
  public function createAction(Request $request, $type) {
    $entity = $this->createEnergiforsyning($type);
    $form = $this->createCreateForm($entity, $type);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('energiforsyning_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Energiforsyning entity.
   *
   * @param Energiforsyning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Energiforsyning $entity, $type) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className(), $entity, array(
      'action' => $this->generateUrl('energiforsyning_create', array('type' => $type)),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  private function createDetailCreateForm(Energiforsyning $energiforsyning, EnergiforsyningDetail $detail = null) {
    if (!$detail) {
      $detail = $this->createDetailEntity($energiforsyning);
    }
    $formClass = $this->getFormTypeClassName($detail, true);
    $form = $this->createForm(new $formClass(), $detail, array(
      'action' => $this->generateUrl('energiforsyning_detail_new', array('id' => $energiforsyning->getId())),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Detail entity.
   *
   * @Route("/{id}/detail", name="energiforsyning_detail_new")
   * @Method("POST")
   * @Template()
   */
  public function createDetailAction(Request $request, Energiforsyning $energiforsyning) {
    $detail = $this->createDetailEntity($energiforsyning);
    $form = $this->createDetailCreateForm($energiforsyning, $detail);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $detail->setEnergiforsyning($energiforsyning);
      $detail->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($detail);
      $em->flush();

      return $this->redirect($this->generateUrl('energiforsyning_show', array('id' => $energiforsyning->getId())));
    }

    // @FIXME: How do we handle form errors in modal?

    $template = $this->getTemplate($energiforsyning, 'new');
    return $this->render($template, array(
      'entity' => $detail,
      'form' => $form->createView(),
    ));
  }

  /**
   * @param $type
   * @return mixed
   * @throws Exception
   */
  private function createEnergiforsyning($type) {
    $className = 'AppBundle\\Entity\\'.ucwords($type).'Energiforsyning';
    if (!class_exists($className) || !is_subclass_of($className, 'AppBundle\\Entity\\Energiforsyning')) {
      throw new Exception('Invalid type: '.$type);
    }
    return new $className();
  }

  /**
   * Get name of an entity
   *
   * @param object $entity
   * @return string
   */
  private function getEntityName($entity) {
    $className = get_class($entity);
    if (preg_match('@\\\\([^\\\\]+)$@', $className, $matches)) {
      return $matches[1];
    }
    return $className;
  }

  /**
   * Get template for an entity and an action.
   * If a specific template for the entity does not exist, a fallback template is returned.
   *
   * @param Energiforsyning $entity
   * @param string $action
   * @return string
   */
  private function getTemplate(Energiforsyning $entity, $action) {
    $className = $this->getEntityName($entity);
    $template = 'AppBundle:'.$className.':'.$action.'.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:Energiforsyning:'.$action.'.html.twig';
    }
    return $template;
  }

  /**
   * Get form type class name for a entity
   *
   * @param Energiforsyning|EnergiforsyningDetail $entity
   * @param boolean $isDetail
   * @return string
   */
  private function getFormTypeClassName($entity, $isDetail = false) {
    $className = '\\AppBundle\\Form\\Type\\'.$this->getEntityName($entity).'Type';
    if (!class_exists($className)) {
      $className = '\\AppBundle\\Form\\Type\\Energiforsyning'.($isDetail ? 'Detail' : '').'Type';
    }
    return $className;
  }

  /**
   * @param Energiforsyning $entity
   * @return string
   * @throws \Exception
   */
  private function getDetailClassName(Energiforsyning $entity) {
    $entityName = $this->getEntityName($entity);
    $className = '\\AppBundle\\Entity\\'.$entityName.'Detail';
    if (!class_exists($className)) {
      throw new Exception('Cannot find details entity for: '.$entityName);
    }
    return $className;
  }

  /**
   * @param Energiforsyning $energiforsyning
   * @return EnergiforsyningDetail
   * @throws \Exception
   */
  private function createDetailEntity(Energiforsyning $energiforsyning) {
    $detailClass = $this->getDetailClassName($energiforsyning);
    $detail = new $detailClass();
    return $detail;
  }


  //---------------- Regning -------------------//

  /**
   * Creates a new Regning entity.
   *
   * @Route("/{id}/regning/new", name="regning_create_x")
   * @Method("POST")
   * @Template("AppBundle:Regning:new.html.twig")
   */
  public function newRegningAction(Request $request, Energiforsyning $energiforsyning) {
    $em = $this->getDoctrine()->getManager();
    $regning = new Regning();

    $regning->setEnergiforsyning($energiforsyning);

    $em->persist($regning);
    $em->flush();

    return $this->redirect($this->generateUrl('regning_show', array('id' => $regning->getId())));
  }

}
