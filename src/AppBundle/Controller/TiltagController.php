<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Regning;
use AppBundle\Form\Type\TiltagOverviewDetailType;
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
  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Rapporter', $this->generateUrl('rapport'));
  }

  private function setBreadcrumb(Tiltag $tiltag) {
    $this->breadcrumbs->addItem($tiltag->getRapport(), $this->get('router')->generate('rapport_show', array('id' => $tiltag->getRapport()->getId())));
    $this->breadcrumbs->addItem($tiltag->getTitle(), $this->get('router')->generate('tiltag_show', array('id' => $tiltag->getId())));
  }

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
   * @Security("is_granted('TILTAG_VIEW', tiltag)")
   * @param Tiltag $tiltag
   * @return \Symfony\Component\HttpFoundation\Response
   */
  public function showAction(Tiltag $tiltag) {
    $this->setBreadcrumb($tiltag);

    $editForm = $this->createOverviewForm($tiltag);
    $details = array();
    foreach($tiltag->getDetails() as $detail) {
      $details[$detail->getId()] = $detail;
    }

    $template = $this->getTemplate($tiltag, 'show');
    return $this->render($template, array(
      'entity' => $tiltag,
      'details' => $details,
      'edit_form' => $editForm->createView(),
    ));
  }

  /**
   * Displays a form to edit an existing Tiltag entity.
   *
   * @Route("/{id}/edit", name="tiltag_edit")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function editAction(Tiltag $tiltag) {
    $this->setBreadcrumb($tiltag);
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('tiltag_edit', array('id' => $tiltag->getId())));

    $editForm = $this->createEditForm($tiltag);
    $deleteForm = $this->createDeleteForm($tiltag);

    $template = $this->getTemplate($tiltag, 'edit');
    return $this->render($template, array(
      'entity' => $tiltag,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
   * Creates a form to edit a Tiltag entity.
   *
   * @param Tiltag $tiltag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Tiltag $tiltag) {
    $className = $this->getFormTypeClassName($tiltag);
    $form = $this->createForm(new $className($tiltag, $this->get('security.context')), $tiltag, array(
      'action' => $this->generateUrl('tiltag_update', array('id' => $tiltag->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));

    return $form;
  }

  /**
   * Creates a form to select/deselect TiltagDetail entities.
   *
   * @param Tiltag $tiltag The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createOverviewForm(Tiltag $tiltag) {
    $form = $this->createForm(new TiltagOverviewDetailType(), $tiltag, array(
      'action' => $this->generateUrl('tiltag_overview_update', array('id' => $tiltag->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));

    return $form;
  }

  /**
   * Edits an existing Tiltag entity.
   *
   * @Route("/{id}", name="tiltag_update")
   * @Method("PUT")
   * @Template("AppBundle:Tiltag:edit.html.twig")
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function updateAction(Request $request, Tiltag $tiltag) {
    $deleteForm = $this->createDeleteForm($tiltag);
    $editForm = $this->createEditForm($tiltag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('tiltag.confirmation.updated');

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    }

    return array(
      'entity' => $tiltag,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Edits an existing Tiltag entity.
   *
   * @Route("/{id}/overview", name="tiltag_overview_update")
   * @Method("PUT")
   * @Template("AppBundle:Tiltag:show.html.twig")
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function updateOverviewAction(Request $request, Tiltag $tiltag) {
    $editForm = $this->createOverviewForm($tiltag);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('tiltag.confirmation.updated');

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    }

    return array(
      'entity' => $tiltag,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Edits "tilvalgt" for an existing Tiltag entity.
   *
   * @Route("/tilvalgt/{id}", name="tiltag_tilvalgt_update")
   * @Method("PUT")
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function updateTilvalgtAction(Request $request, Tiltag $tiltag) {
    $editForm = $this->createForm(new TiltagTilvalgtType($tiltag), $tiltag, array(
      'action' => $this->generateUrl('tiltag_tilvalgt_update', array('id' => $tiltag->getId())),
      'method' => 'PUT',
    ));

    $editForm->handleRequest($request);

    $flash = $this->get('braincrafted_bootstrap.flash');
    $flash->success('tiltag.confirmation.tilfravalgtupdated');

    $em = $this->getDoctrine()->getManager();
    $em->flush();

    return $this->redirectToReferer($request);
  }

  /**
   * Deletes a Tiltag entity.
   *
   * @Route("/{id}", name="tiltag_delete")
   * @Method("DELETE")
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function deleteAction(Request $request, Tiltag $tiltag) {
    $form = $this->createDeleteForm($tiltag);
    $form->handleRequest($request);

    $rapport = $tiltag->getRapport();

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($tiltag);
      $em->flush();

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('tiltag.confirmation.deleted');
    }

    return $this->redirect($this->generateUrl('rapport_show', array('id' => $rapport->getId())));
  }

  /**
   * Creates a form to delete a Tiltag entity
   *
   * @param Tiltag $tiltag
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm(Tiltag $tiltag) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('tiltag_delete', array('id' => $tiltag->getId())))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array('label' => 'Delete'))
      ->getForm();
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
   * Get template for an tiltag and an action.
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
   * Get template for an tiltagdetail and an action.
   * If a specific template for the entity does not exist, a fallback template is returned.
   *
   * @param Tiltag $entity
   * @param string $action
   * @return string
   */
  private function getDetailTemplate(TiltagDetail $entity, $action) {
    $className = $this->getEntityName($entity);
    $template = 'AppBundle:' . $className . ':' . $action . '.html.twig';
    if (!$this->get('templating')->exists($template)) {
      $template = 'AppBundle:TiltagDetail:' . $action . '.html.twig';
    }
    return $template;
  }

  //---------------- TiltagDetail -------------------//

  /**
   * Displays a form to create a new TiltagDetail entity.
   *
   * @Route("/{id}/detailnew", name="tiltag_detail_new")
   * @Method("GET")
   * @Template()
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function newDetailAction(Tiltag $tiltag) {
    $this->setBreadcrumb($tiltag);
    $type = strtolower($this->getEntityName($tiltag));
    $this->breadcrumbs->addItem($type.'detail.actions.add', $this->get('router')->generate('tiltag_detail_new', array('id' => $tiltag->getId())));

    $detail = $this->createDetailEntity($tiltag);
    $detail->init($tiltag);
    $form = $this->createDetailCreateForm($tiltag, $detail);
    $template = $this->getDetailTemplate($detail, 'new');

    return $this->render($template, array(
      'entity' => $detail,
      'edit_form' => $form->createView(),
    ));
  }

  private function createDetailCreateForm(Tiltag $tiltag, TiltagDetail $detail = NULL) {
    if (!$detail) {
      $detail = $this->createDetailEntity($tiltag);
    }
    $formClass = $this->getFormTypeClassName($detail, TRUE);
    $form = $this->createForm(new $formClass($this->container), $detail, array(
      'action' => $this->generateUrl('tiltag_detail_new', array('id' => $tiltag->getId())),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array('label' => 'Create'));

    return $form;
  }

  /**
   * Displays a form to create a new Detail entity.
   *
   * @Route("/{id}/detailnew", name="tiltag_detail_create")
   * @Method("POST")
   * @Template()
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
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

      $flash = $this->get('braincrafted_bootstrap.flash');
      $flash->success('tiltagdetail.confirmation.created');

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    }

    $template = $this->getDetailTemplate($detail, 'new');
    return $this->render($template, array(
      'entity' => $detail,
      'edit_form' => $form->createView(),
    ));
  }

  /**
   * Get form type class name for a entity
   *
   * @param Tiltag|TiltagDetail $tiltag
   * @param boolean $isDetail
   * @return string
   */
  private function getFormTypeClassName($tiltag, $isDetail = FALSE) {
    $className = '\\AppBundle\\Form\\Type\\' . $this->getEntityName($tiltag) . 'Type';
    if (!class_exists($className)) {
      $className = '\\AppBundle\\Form\\Type\\Tiltag' . ($isDetail ? 'Detail' : '') . 'Type';
    }
    return $className;
  }

  /**
   * @param Tiltag $tiltag
   * @return string
   * @throws \Exception
   */
  private function getDetailClassName(Tiltag $tiltag) {
    $entityName = $this->getEntityName($tiltag);
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
   * @Security("has_role('ROLE_ADMIN')")
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
