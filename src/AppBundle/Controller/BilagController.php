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

/**
 * Bilag controller.
 *
 * @Route("/bilag")
 */
class BilagController extends BaseController {
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Bilag', $this->generateUrl('bilag'));
  }

  /**
   * Displays a form to edit an existing Bilag entity.
   *
   * @Route("/{id}/edit", name="bilag_edit")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('BILAG_EDIT', bilag)")
   */
  public function editAction(Bilag $bilag) {
    // @TODO: Breadcrumb

    $editForm = $this->createEditForm($bilag);
    // @TODO: Delete form

    $template = $this->getTemplate($bilag, 'edit');
    return $this->render($template, array(
      'entity' => $bilag,
      'edit_form' => $editForm->createView(),
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
    $className = $this->getFormTypeClassName($bilag);
    $form = $this->createForm(new $className($bilag, $this->get('security.context')), $bilag, array(
      'action' => $this->generateUrl('bilag_update', array('id' => $bilag->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('bilag_show', array('id' => $bilag->getId())));

    return $form;
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
    $className = $this->getEntityName($entity);
    $template = 'AppBundle:' . $className . ':' . $action . '.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:Bilag:' . $action . '.html.twig';
    }
    return $template;
  }
}
