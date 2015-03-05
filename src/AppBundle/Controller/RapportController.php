<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\PumpeTiltag;
use AppBundle\Entity\SpecialTiltag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Rapport;
use AppBundle\Form\RapportType;
use AppBundle\Entity\Tiltag;
use AppBundle\Form\TiltagType;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Rapport controller.
 *
 * @Route("/rapport")
 */
class RapportController extends Controller implements InitControllerInterface {

  protected $breadcrumbs;

  public function init(Request $request)
  {
    $this->breadcrumbs = $this->get("white_october_breadcrumbs");
    $this->breadcrumbs->addItem("Dashboard", $this->get("router")->generate("dashboard"));
    $this->breadcrumbs->addItem("Bygninger", $this->get("router")->generate("bygning"));
    $this->breadcrumbs->addItem("Rapport");
  }

  /**
   * Lists all Rapport entities.
   *
   * @Route("/", name="rapport")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Rapport')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}", name="rapport_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Rapport')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Rapport entity.');
    }

    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Displays a form to edit an existing Rapport entity.
   *
   * @Route("/{id}/edit", name="rapport_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Rapport')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Rapport entity.');
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
   * Creates a form to edit a Rapport entity.
   *
   * @param Rapport $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Rapport $entity) {
    $form = $this->createForm(new RapportType(), $entity, array(
      'action' => $this->generateUrl('rapport_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array('label' => 'Update'));

    return $form;
  }

  /**
   * Edits an existing Rapport entity.
   *
   * @Route("/{id}", name="rapport_update")
   * @Method("PUT")
   * @Template("AppBundle:Rapport:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Rapport')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Rapport entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('rapport_edit', array('id' => $id)));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Rapport entity.
   *
   * @Route("/{id}", name="rapport_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Rapport')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Rapport entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('rapport'));
  }

  /**
   * Creates a form to delete a Rapport entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('rapport_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  //---------------- Tiltag -------------------//

  /**
   * Creates a new Tiltag entity.
   *
   * @Route("/{id}/tiltag/{type}", name="tiltag_create")
   * @Method("GET")
   * @Template("AppBundle:Tiltag:new.html.twig")
   */
  public function createAction(Request $request, $id, $type) {
    $em = $this->getDoctrine()->getManager();

    $rapport = $em->getRepository('AppBundle:Rapport')->find($id);

    if (!$rapport) {
      throw $this->createNotFoundException('Unable to find Rapport entity.');
    }

    switch ($type) {
      case 'pumpe':
        $entity = new PumpeTiltag();
        $entity->setTitle('Pumpeudskiftninger');
        break;
      case 'special':
        $entity = new SpecialTiltag();
        break;
      default:
        throw new \InvalidArgumentException('Unknown tiltag type');
    }

    $entity->setRapport($rapport);
    $em = $this->getDoctrine()->getManager();
    $em->persist($entity);
    $em->flush();

    return $this->redirect($this->generateUrl('tiltag_show', array('id' => $entity->getId())));
  }
}
