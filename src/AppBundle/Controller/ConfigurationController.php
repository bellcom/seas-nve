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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Configuration;
use AppBundle\Form\Type\ConfigurationType;

/**
 * Configuration controller.
 *
 * @Route("/configuration")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ConfigurationController extends BaseController {
  private $configuration;

  private function getConfiguration() {
    if ($this->configuration === NULL) {
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AppBundle:Configuration');
      $this->configuration = $repository->getConfiguration();
    }
    return $this->configuration;
  }

  /**
   * Lists all Configuration entities.
   *
   * @Route("/", name="configuration")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $this->breadcrumbs->addItem('configuration.labels.singular', $this->generateUrl('configuration'));

    $entity = $this->getConfiguration();

    return array(
      'entity' => $entity,
    );
  }

  /**
   * Displays a form to edit an existing Configuration entity.
   *
   * @Route("/edit", name="configuration_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction() {
    $this->breadcrumbs->addItem('configuration.labels.singular', $this->generateUrl('configuration'));
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('configuration_edit'));

    $entity = $this->getConfiguration();

    if (!$this->container->get('security.context')->isGranted('CONFIGURATION_EDIT', $entity)) {
      throw $this->createAccessDeniedException('You are not allowed to do this');
    }

    $editForm = $this->createEditForm($entity);

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Edits an existing Configuration entity.
   *
   * @Route("/", name="configuration_update")
   * @Method("PUT")
   * @Template("AppBundle:Configuration:edit.html.twig")
   */
  public function updateAction(Request $request) {
    $entity = $this->getConfiguration();

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Configuration entity.');
    }

    if (!$this->container->get('security.context')->isGranted('CONFIGURATION_EDIT', $entity)) {
      throw $this->createAccessDeniedException('You are not allowed to do this');
    }

    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      return $this->redirect($this->generateUrl('configuration'));
    }

    return array(
      'entity' => $entity,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Configuration entity.
   *
   * @param Configuration $configuration The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Configuration $configuration) {
    $form = $this->createForm(new ConfigurationType($this->get('security.context')), $configuration, array(
      'action' => $this->generateUrl('configuration_update'),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('configuration'));

    return $form;
  }

}
