<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Form\Type\TiltagTilvalgtType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Rapport;
use AppBundle\Form\Type\RapportType;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Rapport controller.
 *
 * @Route("/rapport")
 */
class RapportController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
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
    $user = $this->get('security.context')->getToken()->getUser();

    $entities = $em->getRepository('AppBundle:Rapport')->findByUser($user);

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
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->generateUrl('bygning_show', array(
      'id' => $rapport->getBygning()
        ->getId()
    )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->generateUrl('rapport_show', array('id' => $rapport->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId())->createView();

    $editForm = $this->createEditFormFinansiering($rapport);

    $tilvalgtFormArray = array();
    $fravalgtFormArray = array();

    if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
      foreach ($rapport->getTiltag() as $tiltag) {
        if ($tiltag->getTilvalgt()) {
          $tilvalgtFormArray[$tiltag->getId()] = $this->createEditTilvalgTilvalgtForm($tiltag, $rapport)
            ->createView();
        }
        else {
          $fravalgtFormArray[$tiltag->getId()] = $this->createEditTilvalgTilvalgtForm($tiltag, $rapport)
            ->createView();
        }
      }
    }

    return array(
      'entity' => $rapport,
      'tilvalgt_form_array' => $tilvalgtFormArray,
      'fravalgt_form_array' => $fravalgtFormArray,
      'delete_form' => $deleteForm,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
    );
  }

  /**
   * Displays a form to edit an existing Rapport entity.
   *
   * @Route("/{id}/edit", name="rapport_edit")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_EDIT', rapport)")
   */
  public function editAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->generateUrl('bygning_show', array(
      'id' => $rapport->getBygning()
        ->getId()
    )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->generateUrl('rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('rapport_edit', array('id' => $rapport->getId())));

    $editForm = $this->createEditForm($rapport);
    $deleteForm = $this->createDeleteForm($rapport->getId());

    return array(
      'entity' => $rapport,
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
    $form = $this->createForm(new RapportType($this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('rapport_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('rapport_show', array('id' => $entity->getId())));

    return $form;
  }

  /**
   * Creates a form to edit a Tiltag entity.
   *
   * @param Tiltag $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditTilvalgTilvalgtForm($entity, Rapport $rapport) {

    $form = $this->createForm(new TiltagTilvalgtType($entity), $entity, array(
      'action' => $this->generateUrl('tiltag_tilvalgt_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form);
    //$form->add('submit', 'submit', array('label' => 'Create'));

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

      return $this->redirect($this->generateUrl('rapport_show', array('id' => $id)));
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
   * @Route("/{id}/tiltag/new/{type}", name="tiltag_create")
   * @Method("POST")
   * @Template("AppBundle:Tiltag:new.html.twig")
   */
  public function newTiltagAction(Request $request, Rapport $rapport, $type) {
    $em = $this->getDoctrine()->getManager();
    $tiltag = $em->getRepository('AppBundle:Tiltag')->create($type);

    $tiltag->setRapport($rapport);

    $em->persist($tiltag);
    $em->flush();

    return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
  }

  //---------------- Regninger -------------------//

  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}/regninger", name="rapport_regninger_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showRegningerAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->get('router')
      ->generate('bygning_show', array(
        'id' => $rapport->getBygning()
          ->getId()
      )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->get('router')
      ->generate('rapport_show', array('id' => $rapport->getId())));

    $deleteForm = $this->createDeleteForm($rapport->getId());

    return array(
      'tiltag' => $rapport->getTiltag(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Finds and displays a Rapport entity.
   *
   * @Route("/{id}/finansiering", name="rapport_finansiering_show")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('RAPPORT_VIEW', rapport)")
   * @param Rapport $rapport
   * @return array
   */
  public function showFinansieringAction(Rapport $rapport) {
    $this->breadcrumbs->addItem($rapport->getBygning(), $this->get('router')
      ->generate('bygning_show', array(
        'id' => $rapport->getBygning()
          ->getId()
      )));
    $this->breadcrumbs->addItem($rapport->getVersion(), $this->get('router')
      ->generate('rapport_show', array('id' => $rapport->getId())));

    $editForm = $this->createEditFormFinansiering($rapport);

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm ? $editForm->createView() : NULL,
    );
  }

  /**
   * Creates a form to edit a Rapport entity.
   *
   * @param Rapport $rapport The rapport
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditFormFinansiering(Rapport $rapport) {
    if (!$this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
      return NULL;
    }

    $form = $this->createFormBuilder($rapport)
      ->setAction($this->generateUrl('rapport_finansiering_update', array('id' => $rapport->getId())))
      ->setMethod('PUT')
      ->add('laanLoebetid', NULL, array(
        'attr' => array(
          'input_group' => array(
            'append' => 'år'
          )
        ),
      ))
      ->getForm();

    $this->addUpdate($form);

    return $form;
  }

  /**
   * Edits an existing Rapport entity.
   *
   * @Route("/{id}/finansiering", name="rapport_finansiering_update")
   * @Method("PUT")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function updateActionFinansiering(Request $request, Rapport $rapport) {
    $em = $this->getDoctrine()->getManager();

    $editForm = $this->createEditFormFinansiering($rapport);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($request->headers->get('referer'));
    }

    return array(
      'entity' => $rapport,
      'edit_form' => $editForm->createView(),
    );
  }

}
