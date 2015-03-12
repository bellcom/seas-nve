<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Tiltag;
use AppBundle\Entity\TiltagDetail;

/**
 * Tiltag controller.
 *
 * @Route("/tiltag")
 */
class TiltagController extends Controller {
  /**
   * Lists all Tiltag entities.
   *
   * @Route("/", name="tiltag")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Tiltag')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Finds and displays a Tiltag entity.
   *
   * @Route("/{id}", name="tiltag_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction(Tiltag $entity) {
    $deleteForm = $this->createDeleteForm($entity);
    $form = $this->createDetailCreateForm($entity);

    $template = $this->getTemplate($entity, 'show');
    return $this->render($template, array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
      'create_detail_form' => $form->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing Tiltag entity.
   *
   * @Route("/{id}/edit", name="tiltag_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Tiltag $entity) {
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
   * Creates a form to edit a Tiltag entity.
   *
   * @param Tiltag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Tiltag $entity) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className(), $entity, array(
      'action' => $this->generateUrl('tiltag_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing Tiltag entity.
   *
   * @Route("/{id}", name="tiltag_update")
   * @Method("PUT")
   * @Template("AppBundle:Tiltag:edit.html.twig")
   */
  public function updateAction(Request $request, Tiltag $entity) {
    $deleteForm = $this->createDeleteForm($entity);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('tiltag_edit', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Tiltag entity.
   *
   * @Route("/{id}", name="tiltag_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, Tiltag $entity) {
    $form = $this->createDeleteForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('tiltag'));
  }

  /**
   * Creates a form to delete a Tiltag entity
   *
   * @param Tiltag $entity
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Tiltag $entity) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('tiltag_delete', array('id' => $entity->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Displays a form to create a new Tiltag entity.
   *
   * @Route("/new/{type}", name="tiltag_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction($type) {
    $entity = $this->createTiltag($type);
    $form = $this->createCreateForm($entity, $type);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a new Tiltag entity.
   *
   * @Route("/new/{type}", name="x_tiltag_create")
   * @Method("POST")
   * @Template("AppBundle:Tiltag:new.html.twig")
   */
  public function createAction(Request $request, $type) {
    $entity = $this->createTiltag($type);
    $form = $this->createCreateForm($entity, $type);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Tiltag entity.
   *
   * @param Tiltag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Tiltag $entity, $type) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className(), $entity, array(
      'action' => $this->generateUrl('tiltag_create', array('type' => $type)),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  private function createDetailCreateForm(Tiltag $tiltag, TiltagDetail $detail = null) {
    if (!$detail) {
      $detail = $this->createDetailEntity($tiltag);
    }
    $formClass = $this->getFormTypeClassName($detail, true);
    $form = $this->createForm(new $formClass(), $detail, array(
      'action' => $this->generateUrl('tiltag_detail_new', array('id' => $tiltag->getId())),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Detail entity.
   *
   * @Route("/{id}/detail", name="tiltag_detail_new")
   * @Method("POST")
   * @Template()
   */
  public function createDetailAction(Request $request, Tiltag $tiltag) {
    $detail = $this->createDetailEntity($tiltag);
    $form = $this->createDetailCreateForm($tiltag, $detail);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $detail->setTiltag($tiltag);
      $detail->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($detail);
      $em->flush();

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    }

    // @FIXME: How do we handle form errors in modal?

    $template = $this->getTemplate($detail, 'new');
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
  private function createTiltag($type) {
    $className = 'AppBundle\\Entity\\'.ucwords($type).'Tiltag';
    if (!class_exists($className) || !is_subclass_of($className, 'AppBundle\\Entity\\Tiltag')) {
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
   * @param Tiltag $entity
   * @param string $action
   * @return string
   */
  private function getTemplate(Tiltag $entity, $action) {
    $className = $this->getEntityName($entity);
    $template = 'AppBundle:'.$className.':'.$action.'.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:Tiltag:'.$action.'.html.twig';
    }
    return $template;
  }

  /**
   * Get form type class name for a entity
   *
   * @param Tiltag|TiltagDetail $entity
   * @param boolean $isDetail
   * @return string
   */
  private function getFormTypeClassName($entity, $isDetail = false) {
    $className = '\\AppBundle\\Form\\Type\\'.$this->getEntityName($entity).'Type';
    if (!class_exists($className)) {
      $className = '\\AppBundle\\Form\\Tiltag'.($isDetail ? 'Detail' : '').'Type';
    }
    return $className;
  }

  /**
   * @param Tiltag $entity
   * @return string
   */
  private function getDetailClassName(Tiltag $entity) {
    $entityName = $this->getEntityName($entity);
    $className = '\\AppBundle\\Entity\\'.$entityName.'Detail';
    if (!class_exists($className)) {
      throw new Exception('Cannot find details entity for: '.$entityName);
    }
    return $className;
  }

  private function createDetailEntity(Tiltag $tiltag) {
    $detailClass = $this->getDetailClassName($tiltag);
    $detail = new $detailClass();
    return $detail;
  }
}
