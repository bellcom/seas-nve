<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Regning;
use AppBundle\Form\Type\TiltagTilvalgtType;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use AppBundle\Entity\Tiltag;
use AppBundle\Entity\TiltagDetail;
use Yavin\Symfony\Controller\InitControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Tiltag controller.
 *
 * @Route("/tiltag")
 */
class TiltagController extends BaseController {
  /**
   * Lists all Tiltag entities.
   *
   * @Route("/", name="tiltag")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    return $this->redirect($this->generateUrl('dashboard'));
  }

  /**
   * Finds and displays a Tiltag entity.
   *
   * @Route("/{id}", name="tiltag_show")
   * @Method("GET")
   * @Template()
   * @param Tiltag $entity
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Tiltag $entity) {
    $this->breadcrumbs->addItem($entity->getRapport()
      ->getBygning(), $this->get('router')
      ->generate('bygning_show', array(
        'id' => $entity->getRapport()
          ->getBygning()
          ->getId()
      )));
    $this->breadcrumbs->addItem($entity->getRapport()
      ->getVersion(), $this->get('router')
      ->generate('rapport_show', array(
        'id' => $entity->getRapport()
          ->getId()
      )));
    $this->breadcrumbs->addItem($entity->getTitle(), $this->get('router')
      ->generate('rapport_show', array(
        'id' => $entity->getRapport()
          ->getId()
      )));

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
   * Displays a form to edit an existing Tiltag entity.
   *
   * @Route("/{id}/edit", name="tiltag_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Tiltag $entity) {
    $this->breadcrumbs->addItem($entity->getRapport()
      ->getBygning(), $this->get('router')
      ->generate('bygning_show', array(
        'id' => $entity->getRapport()
          ->getBygning()
          ->getId()
      )));
    $this->breadcrumbs->addItem($entity->getRapport()
      ->getVersion(), $this->get('router')
      ->generate('rapport_show', array(
        'id' => $entity->getRapport()
          ->getId()
      )));
    $this->breadcrumbs->addItem($entity->getTitle(), $this->get('router')
      ->generate('rapport_show', array(
        'id' => $entity->getRapport()
          ->getId()
      )));

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
    $form = $this->createForm(new $className($entity), $entity, array(
      'action' => $this->generateUrl('tiltag_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('tiltag_show', array('id' => $entity->getId())));

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

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Edits "tilvalgt" for an existing Tiltag entity.
   *
   * @Route("/tilvalgt/{id}", name="tiltag_tilvalgt_update")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function updateTilvalgtAction(Request $request, Tiltag $entity) {
    //$editForm = $this->createForm($entity);
    //$editForm = $this->createForm(new TiltagTilvalgtType($entity), $entity);

    $editForm = $this->createForm(new TiltagTilvalgtType($entity), $entity, array(
      'action' => $this->generateUrl('tiltag_tilvalgt_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $editForm->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    $em->flush();

    return $this->redirectToReferer($request);
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

    $rapport = $entity->getRapport();

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('rapport_show', array('id' => $rapport->getId())));
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
    $form = $this->createForm(new $className($entity), $entity, array(
      'action' => $this->generateUrl('tiltag_create', array('type' => $type)),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  private function createDetailCreateForm(Tiltag $tiltag, TiltagDetail $detail = NULL) {
    if (!$detail) {
      $detail = $this->createDetailEntity($tiltag);
    }
    $formClass = $this->getFormTypeClassName($detail, TRUE);
    $form = $this->createForm(new $formClass($this->get('security.context')), $detail, array(
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

    $template = $this->getTemplate($tiltag, 'new');
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
    $className = 'AppBundle\\Entity\\' . ucwords($type) . 'Tiltag';
    if (!class_exists($className) || !is_subclass_of($className, 'AppBundle\\Entity\\Tiltag')) {
      throw new Exception('Invalid type: ' . $type);
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
    $template = 'AppBundle:' . $className . ':' . $action . '.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:Tiltag:' . $action . '.html.twig';
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
  private function getFormTypeClassName($entity, $isDetail = FALSE) {
    $className = '\\AppBundle\\Form\\Type\\' . $this->getEntityName($entity) . 'Type';
    if (!class_exists($className)) {
      $className = '\\AppBundle\\Form\\Type\\Tiltag' . ($isDetail ? 'Detail' : '') . 'Type';
    }
    return $className;
  }

  /**
   * @param Tiltag $entity
   * @return string
   * @throws \Exception
   */
  private function getDetailClassName(Tiltag $entity) {
    $entityName = $this->getEntityName($entity);
    $className = '\\AppBundle\\Entity\\' . $entityName . 'Detail';
    if (!class_exists($className)) {
      throw new Exception('Cannot find details entity for: ' . $entityName);
    }
    return $className;
  }

  /**
   * @param Tiltag $tiltag
   * @return TiltagDetail
   * @throws \Exception
   */
  private function createDetailEntity(Tiltag $tiltag) {
    $detailClass = $this->getDetailClassName($tiltag);
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
  public function newRegningAction(Request $request, Tiltag $tiltag) {
    $em = $this->getDoctrine()->getManager();
    $regning = new Regning();

    $regning->setTiltag($tiltag);

    $em->persist($regning);
    $em->flush();

    return $this->redirect($this->generateUrl('regning_show', array('id' => $regning->getId())));
  }

}
