<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\TiltagDetail;

/**
 * TiltagDetail controller.
 *
 * @Route("/tiltag_detail")
 */
class TiltagDetailController extends BaseController {
  private function setBreadcrumb(TiltagDetail $detail) {
    $tiltag = $detail->getTiltag();
    $rapport = $tiltag->getRapport();
    $bygning = $rapport->getBygning();
    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem($tiltag, $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    $this->breadcrumbs->addItem(get_class($detail));
  }

  /**
   * Finds and displays a TiltagDetail entity.
   *
   * @Route("/{id}", name="tiltag_detail_show")
   * @Method("GET")
   * @Template()
   * @param TiltagDetail $entity
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(TiltagDetail $entity) {
    $this->setBreadcrumb($entity);
    $deleteForm = $this->createDeleteForm($entity);

    $template = $this->getTemplate($entity, 'show');
    return $this->render($template, array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing TiltagDetail entity.
   *
   * @Route("/{id}/edit", name="tiltag_detail_edit")
   * @Method("GET")
   * @Template()
   * @param TiltagDetail $entity
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function editAction(TiltagDetail $entity) {
    $this->setBreadcrumb($entity);
    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($entity);

    $template = $this->getTemplate($entity, 'edit');
    return $this->render($template, array(
      'calculation_changes' => $this->container->get('aaplus.tiltagdetail_calculation')->getChanges($entity),
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Creates a form to edit a TiltagDetail entity.
   *
   * @param TiltagDetail $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(TiltagDetail $entity) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('tiltag_detail_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('tiltag_show', array('id' => $entity->getTiltag()->getId())));

    return $form;
  }

  /**
   * Edits an existing TiltagDetail entity.
   *
   * @Route("/{id}", name="tiltag_detail_update")
   * @Method("PUT")
   * @Template("AppBundle:TiltagDetail:edit.html.twig")
   * @param Request $request
   * @param TiltagDetail $entity
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function updateAction(Request $request, TiltagDetail $entity) {
    $deleteForm = $this->createDeleteForm($entity);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $entity->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $entity->getTiltag()->getId())));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a TiltagDetail entity.
   *
   * @Route("/{id}", name="tiltag_detail_delete")
   * @Method("DELETE")
   * @param Request $request
   * @param TiltagDetail $detail
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   */
  public function deleteAction(Request $request, TiltagDetail $detail) {
    $form = $this->createDeleteForm($detail);
    $form->handleRequest($request);
    $tiltag = $detail->getTiltag();

    if ($form->isValid()) {
      $detail->setTiltag(null);
      $em = $this->getDoctrine()->getManager();
      $em->remove($detail);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
  }

  /**
   * Creates a form to delete a TiltagDetail entity
   *
   * @param TiltagDetail $entity
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(TiltagDetail $entity) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('tiltag_detail_delete', array('id' => $entity->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Creates a new TiltagDetail entity.
   *
   * @Route("/{type}", name="tiltag_detail_create")
   * @Method("POST")
   * @Template("AppBundle:TiltagDetail:new.html.twig")
   * @param Request $request
   * @param string $type
   * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
   * @throws \Exception
   */
  public function createAction(Request $request, $type) {
    $entity = $this->createTiltagDetail($type);
    $form = $this->createCreateForm($entity, $type);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('tiltag_detail_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a TiltagDetail entity.
   *
   * @param TiltagDetail $entity The entity
   * @param string $type
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(TiltagDetail $entity, $type) {
    $className = $this->getFormTypeClassName($entity);
    $form = $this->createForm(new $className($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('tiltag_detail_create', array('type' => $type)),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Create a new TiltagDetail
   *
   * @param $type
   * @return TiltagDetail
   * @throws \Exception
   */
  private function createTiltagDetail($type) {
    $className = 'AppBundle\\Entity\\'.ucwords($type).'TiltagDetail';
    if (!class_exists($className) || !is_subclass_of($className, 'AppBundle\\Entity\\TiltagDetail')) {
      throw new \Exception('Invalid type: '.$type);
    }
    return new $className();
  }

  /**
   * @param \AppBundle\Entity\TiltagDetail $entity
   * @return string
   */
  private function getEntityName(TiltagDetail $entity) {
    $className = get_class($entity);
    if (preg_match('@\\\\([^\\\\]+)$@', $className, $matches)) {
      return $matches[1];
    }
    return $className;
  }

  /**
   * @param \AppBundle\Entity\TiltagDetail $entity
   * @param $action
   * @return string
   */
  private function getTemplate(TiltagDetail $entity, $action) {
    $className = $this->getEntityName($entity);
    $template = 'AppBundle:'.$className.':'.$action.'.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:TiltagDetail:'.$action.'.html.twig';
    }
    return $template;
  }

  /**
   * @param \AppBundle\Entity\TiltagDetail $entity
   * @return string
   */
  private function getFormTypeClassName(TiltagDetail $entity) {
    $className = '\\AppBundle\\Form\\Type\\'.$this->getEntityName($entity).'Type';
    if (!class_exists($className)) {
      $className = '\\AppBundle\\Form\\TiltagDetailType';
    }
    return $className;
  }
}
