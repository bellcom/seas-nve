<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yavin\Symfony\Controller\InitControllerInterface;

use AppBundle\Entity\Rapport;
use AppBundle\Entity\Energiforsyning;
use AppBundle\Entity\Energiforsyning\InternProduktion;
use AppBundle\Form\Type\EnergiforsyningType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Energiforsyning controller.
 *
 * @Route("/rapport/{rapport_id}/energiforsyning")
 * @ParamConverter("rapport", class="AppBundle:Rapport", options={"id" = "rapport_id"})
 * @Security("is_granted('RAPPORT_EDIT', rapport)")
 */
class EnergiforsyningController extends BaseController {

  protected $breadcrumbs;

  public function init(Request $request)
  {
    parent::init($request);

    $rapport = $this->getRapport();
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
    $this->breadcrumbs->addItem($rapport, $this->generateUrl('rapport_show', array('id' => $rapport->getId())));
    $this->breadcrumbs->addItem('Energiforsyninger', $this->get('router')->generate('energiforsyning', array('rapport_id' => $this->getRapport()->getId())));
  }

  /**
   * Lists all Energiforsyning entities.
   *
   * @Route("/", name="energiforsyning")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $rapport = $this->getRapport();
    $entities = $rapport->getEnergiforsyninger();

    return array(
      'entities' => $entities,
      'rapport' => $rapport,
    );
  }

  /**
   * Displays a form to create a new Energiforsyning entity.
   *
   * @Route("/new", name="energiforsyning_new")
   * @Method("GET")
   * @Template()
   */
  public function newAction() {
    $entity = (new Energiforsyning())
            ->setRapport($this->getRapport());
    $form = $this->createCreateForm($entity);

    return array(
      'entity' => $entity,
      'edit_form' => $form->createView(),
    );
  }

  /**
   * Finds and displays a Energiforsyning entity.
   *
   * @Route("/{id}", name="energiforsyning_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction(Rapport $rapport, Energiforsyning $entity) {
    $this->breadcrumbs->addItem($entity->__toString());

    return array(
      'entity' => $entity,
    );
  }

  /**
   * Displays a form to edit an existing Energiforsyning entity.
   *
   * @Route("/{id}/edit", name="energiforsyning_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Rapport $rapport, Energiforsyning $entity) {
    $this->breadcrumbs->addItem($entity->__toString());

    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($entity);

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Energiforsyning entity.
   *
   * @param Energiforsyning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Energiforsyning $entity) {
    $form = $this->createForm(new EnergiforsyningType(), $entity, array(
      'action' => $this->generateUrl('energiforsyning_update', array('rapport_id' => $entity->getRapport()->getId(), 'id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('energiforsyning_show', array('rapport_id' => $entity->getRapport()->getId(), 'id' => $entity->getId())));

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
    // @See http://symfony.com/doc/current/cookbook/form/form_collections.html.
    $originalInternProduktioner = $entity->getInternProduktioner()->toArray();

    $deleteForm = $this->createDeleteForm($entity);
    $editForm = $this->createEditForm($entity);

    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();

      foreach ($originalInternProduktioner as $internProduktion) {
        if (!$entity->getInternProduktioner()->contains($internProduktion)) {
          $em->remove($internProduktion);
        }
      }

      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('energiforsyning_show', array('rapport_id' => $entity->getRapport()->getId(), 'id' => $entity->getId())));
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
    $flash = $this->get('braincrafted_bootstrap.flash');

    if ($form->isValid()) {
      try {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $flash->success('energiforsyninger.confirmation.deleted');
      } catch (\Exception $e) {
        $flash->error('energiforsyninger.error.cannot_delete');
      }
    }

    return $this->redirect($this->generateUrl('energiforsyning', array('rapport_id' => $entity->getRapport()->getId())));
  }

  /**
   * Creates a form to delete a Energiforsyning entity
   *
   * @param Energiforsyning $entity
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Energiforsyning $entity) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('energiforsyning_delete', array('rapport_id' => $entity->getRapport()->getId(), 'id' => $entity->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Creates a new Energiforsyning entity.
   *
   * @Route("/new", name="energiforsyning_create")
   * @Method("POST")
   * @Template("AppBundle:Energiforsyning:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = (new Energiforsyning())
            ->setRapport($this->getRapport());
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('energiforsyning_show', array('rapport_id' => $entity->getRapport()->getId(), 'id' => $entity->getId())));
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
  private function createCreateForm(Energiforsyning $entity) {
    $form = $this->createForm(new EnergiforsyningType(), $entity, array(
      'action' => $this->generateUrl('energiforsyning_create', array('rapport_id' => $this->getRapport()->getId())),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('energiforsyning', array('rapport_id' => $this->getRapport()->getId())));

    return $form;
  }

  /**
   * Get Rapport from request.
   *
   * @return Rapport
   */
  private function getRapport() {
    $em = $this->getDoctrine()->getManager();

    $rapport = $em->getRepository('AppBundle:Rapport')->findOneById($this->getRequest()->get('rapport_id'));
    if (!$rapport) {
      throw $this->createNotFoundException('Unable to find Rapport entity.');
    }

    return $rapport;
  }

}
