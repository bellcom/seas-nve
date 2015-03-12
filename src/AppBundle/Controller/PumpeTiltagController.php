<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PumpeTiltag;
use AppBundle\Form\Type\PumpeTiltagType;
use AppBundle\Entity\PumpeDetail;
use AppBundle\Form\Type\PumpeDetailType;

/**
 * PumpeTiltag controller.
 *
 * @Route("/pumpetiltag")
 */
class PumpeTiltagController extends Controller {
  /**
   * Lists all PumpeTiltag entities.
   *
   * @Route("/", name="pumpetiltag")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:PumpeTiltag')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new PumpeTiltag entity.
   *
   * @Route("/", name="pumpetiltag_create")
   * @Method("POST")
   * @Template("AppBundle:PumpeTiltag:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new PumpeTiltag();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('pumpetiltag_show', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a PumpeTiltag entity.
   *
   * @param PumpeTiltag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(PumpeTiltag $entity) {
    $form = $this->createForm(new PumpeTiltagType(), $entity, array(
      'action' => $this->generateUrl('pumpetiltag_create'),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new PumpeTiltag entity.
   *
   * @Route("/new", name="pumpetiltag_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $entity = new PumpeTiltag();
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a PumpeTiltag entity.
   *
   * @Route("/{id}", name="pumpetiltag_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:PumpeTiltag')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find PumpeTiltag entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    $detail = new PumpeDetail();
    $form = $this->createDetailCreateForm($detail, $id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
      'form' => $form->createView(),
    );
  }

  /**
   * Displays a form to edit an existing PumpeTiltag entity.
   *
   * @Route("/{id}/edit", name="pumpetiltag_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:PumpeTiltag')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find PumpeTiltag entity.');
    }

    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a PumpeTiltag entity.
   *
   * @param PumpeTiltag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(PumpeTiltag $entity) {
    $form = $this->createForm(new PumpeTiltagType(), $entity, array(
      'action' => $this->generateUrl('pumpetiltag_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing PumpeTiltag entity.
   *
   * @Route("/{id}", name="pumpetiltag_update")
   * @Method("PUT")
   * @Template("AppBundle:PumpeTiltag:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:PumpeTiltag')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find PumpeTiltag entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('pumpetiltag_edit', array('id' => $id)));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a PumpeTiltag entity.
   *
   * @Route("/{id}", name="pumpetiltag_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:PumpeTiltag')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find PumpeTiltag entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('pumpetiltag'));
  }

  /**
   * Creates a form to delete a PumpeTiltag entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('pumpetiltag_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }


  // ----- PumpeDetail ------ //

  /**
   * Creates a form to create a PumpeDetail entity.
   *
   * @param PumpeDetail $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDetailCreateForm(PumpeDetail $entity, $id) {
    $form = $this->createForm(new PumpeDetailType(), $entity, array(
      'action' => $this->generateUrl(
        'pumpetiltag_detail_create',
        array('id' => $id)
      ),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new PumpeDetail entity.
   *
   * @Route("/{id}/detail/new", name="pumpetiltag_detail_new")
   * @Method("GET")
   * @Template()
   */
  public function newDetailAction($id) {
    $entity = new PumpeDetail();
    $form = $this->createCreateForm($entity, $id);

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a new PumpeDetail entity.
   *
   * @Route("/{id}/detail", name="pumpetiltag_detail_create")
   * @Method("POST")
   * @Template("AppBundle:PumpeDetail:new.html.twig")
   */
  public function createDetailAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $pumpetiltag = $em->getRepository('AppBundle:PumpeTiltag')->find($id);

    if (!$pumpetiltag) {
      throw $this->createNotFoundException('Unable to find Pumpetiltag entity.');
    }

    $entity = new PumpeDetail();
    $entity->setPumpetiltag($pumpetiltag);
    $form = $this->createDetailCreateForm($entity, $id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('pumpetiltag_show', array('id' => $id)));
    }

    return array(
      'entity' => $entity,
      'form' => $form->createView(),
    );
  }

}
