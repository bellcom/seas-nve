<?php
/**
 * @file
 * Contains BilagController.
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Yavin\Symfony\Controller\InitControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use AppBundle\Entity\Bilag;
use AppBundle\Form\Type\BilagType;
use AppBundle\Entity\Rapport;

/**
 * Bilag controller.
 *
 * @Route("/bilag")
 */
class BilagController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
//    $this->breadcrumbs->addItem('Bilag', $this->generateUrl('bilag'));
  }

  /**
   * Displays a form to edit an existing Bilag entity.
   *
   * @Route("/{id}/edit", name="bilag_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Bilag $bilag) {
    // @TODO: Breadcrumb

    $editForm = $this->createEditForm($bilag);
    $deleteForm = $this->createDeleteForm($bilag);

    $template = $this->getTemplate($bilag, 'edit');
    return $this->render($template, array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing Bilag entity.
   *
   * @Route("/new/rapport/{id}", name="bilag_rapport_create")
   * @Method("GET")
   * @Template()
   */
  public function createForRapportAction(Rapport $rapport) {
    // @TODO: Breadcrumb

    $bilag = new Bilag();
    $bilag->setRapport($rapport);

    $editForm = $this->createNewForm($bilag);

    $template = $this->getTemplate($bilag, 'new');
    return $this->render($template, array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView()
    ));
  }

  /**
   * Creates a form to edit a Bilag entity.
   *
   * @param Bilag $bilag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Bilag $bilag) {
    $form = $this->createForm(new BilagType($bilag), $bilag, array(
      'action' => $this->generateUrl('bilag_update', array('id' => $bilag->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('bilag_edit', array('id' => $bilag->getId())));

    return $form;
  }

  /**
   * Creates a form to create a Bilag entity.
   *
   * @param Bilag $bilag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createNewForm(Bilag $bilag) {
    $form = $this->createForm(new BilagType($bilag), $bilag, array(
      'action' => $this->generateUrl('bilag_create', array()),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('bilag_create'));

    return $form;
  }

  /**
   * Creates a form to delete a Bilag entity
   *
   * @param Bilag $bilag
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Bilag $tiltag) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('bilag_delete', array('id' => $tiltag->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
  }

  /**
   * Get template for a bilag and an action.
   * If a specific template for the entity does not exist, a fallback template is returned.
   *
   * @param Bilag $entity
   * @param string $action
   * @return string
   */
  private function getTemplate(Bilag $entity, $action) {
    $className = 'Bilag';
    $template = 'AppBundle:' . $className . ':' . $action . '.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:Bilag:' . $action . '.html.twig';
    }
    return $template;
  }

  /**
   * Edits an existing Bilag entity.
   *
   * @Route("/{id}", name="bilag_update")
   * @Method("PUT")
   * @Template("AppBundle:Bilag:edit.html.twig")
   * @TODO Security("is_granted('BILAG_EDIT', bilag)")
   */
  public function updateAction(Request $request, Bilag $bilag) {
    //$deleteForm = $this->createDeleteForm($bilag);
    $editForm = $this->createEditForm($bilag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $bilag->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('bilag.confirmation.updated');

      return $this->redirect($this->generateUrl('bilag_edit', array('id' => $bilag->getId())));
    }

    return array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView()
    );
  }

  /**
   * Creates a new Bilag entity.
   *
   * @Route("", name="bilag_create")
   * @Method("POST")
   * @Template("AppBundle:Bilag:new.html.twig")
   * @TODO Security("is_granted('BILAG_CREATE', bilag)")
   * @
   */
  public function newBilagAction(Request $request) {
    $bilag = new Bilag();

    $editForm = $this->createNewForm($bilag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $bilag->handleUploads($this->get('stof_doctrine_extensions.uploadable.manager'));
      $em = $this->getDoctrine()->getManager();
      $em->persist($bilag);
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('bilag.confirmation.created');

      return $this->redirect($this->generateUrl('bilag_edit', array('id' => $bilag->getId())));
    }

    return array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Deletes a Bilag entity.
   *
   * @Route("/{id}", name="bilag_delete")
   * @Method("DELETE")
   * @TODO Security("is_granted('BILAG_EDIT', tiltag)")
   */
  public function deleteAction(Request $request, Bilag $bilag) {
    $form = $this->createDeleteForm($bilag);
    $form->handleRequest($request);

    $rapport = $bilag->getRapport();

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($bilag);
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('bilag.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('rapport_show', array('id' => $rapport->getId())));
  }

  /**
   * Finds and displays a Bilag entity.
   *
   * @Route("/{id}", name="bilag_show")
   * @Method("GET")
   * @TODO Security("is_granted('BILAG_VIEW', bilag)")
   * @param Bilag $bilag
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Bilag $bilag) {
    $deleteForm = $this->createDeleteForm($bilag);
    $editForm = $this->createEditForm($bilag);

    $template = $this->getTemplate($bilag, 'show');
    return $this->render($template, array(
      'entity' => $bilag,
      'delete_form' => $deleteForm->createView(),
      'edit_form' => $editForm->createView(),
    ));
  }
}
