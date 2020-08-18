<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\KlimaskaermTiltag;
use AppBundle\Entity\Regning;
use AppBundle\Form\Type\TiltagDatoForDriftType;
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

  /**
   * @var Request
   */
  protected $request;

  /**
   * @var TranslatorInterface $tranlator
   */
  private $translator;

  public function init(Request $request) {
    $this->request = $request;
    parent::init($request);
    $this->translator = $this->container->get('translator');
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
    return $this->redirect($this->generateUrl('dashboard_default'));
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
    if (get_class($tiltag) == 'AppBundle\Entity\KlimaskaermTiltag') {
      $this->flash->error($this->translator->trans('klimaskaerm.strings.tobedeleted'));
    }

    $this->setBreadcrumb($tiltag);
    $this->breadcrumbs->addItem('common.edit', $this->generateUrl('tiltag_edit', array('id' => $tiltag->getId())));

    $editForm = $this->createEditForm($tiltag);
    $deleteForm = $this->createDeleteForm($tiltag);

    $template = $this->getTemplate($tiltag, 'edit');
    return $this->render($template, array(
      'entity' => $tiltag,
      'calculation_warnings' => $tiltag->getCalculationWarnings(),
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
    $params = array('id' => $tiltag->getId());

    // Getting desired destination for form redirect.
    $destination = $this->generateUrl('rapport_show', array('id' => $tiltag->getRapport()->getId()));
    if ($this->request->get('destination')) {
      $destination = $this->request->get('destination');
      $params['destination'] = $destination;
    }

    $form = $this->createForm(new $className($tiltag, $this->get('security.context')), $tiltag, array(
      'action' => $this->generateUrl('tiltag_update', $params),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $destination);
    $this->addUpdateAndExit($form, $destination);
    $this->addLinkButton($form, 'detailark', $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())), 'Deatilark');

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

    $this->addUpdate($form);

    return $form;
  }

  /**
   * Edits an existing Tiltag entity.
   *
   * @Route("/{id}/edit", name="tiltag_update")
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

      $this->flash->success('tiltag.confirmation.updated');

      $destination = $request->getRequestUri();
      if ($button_destination = $this->getButtonDestination($editForm)) {
        $destination = $button_destination;
      }
      return $this->redirect($destination);
    }

    $this->flash->error('tiltag.validation.error');

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

      if ($editForm->get('batch_edit_button')->isClicked()) {

        $this->setBreadcrumb($tiltag);
        $type = strtolower($this->getEntityName($tiltag));
        $this->breadcrumbs->addItem($type.'detail.actions.batch_edit', $this->get('router')->generate('tiltag_detail_batch', array('id' => $tiltag->getId())));

        $detail = $this->createDetailEntity($tiltag);
        $form = $this->createDetailBatchEditForm($tiltag, $detail);
        $template = $this->getDetailTemplate($detail, 'new');

        return $this->render($template, array(
          'isBatchEdit' => TRUE,
          'entity' => $detail,
          'edit_form' => $form->createView(),
        ));

      } else {

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $this->flash->success('tiltag.confirmation.updated');

        return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
      }

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

    $this->flash->success('tiltag.confirmation.tilfravalgtupdated');

    $em = $this->getDoctrine()->getManager();
    $em->flush();

    return $this->redirectToReferer($request);
  }

  /**
   * Edits "dato for drift" for an existing Tiltag entity.
   *
   * @Route("/datofordrift/{id}", name="tiltag_dato_for_drift_update")
   * @Method("PUT")
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function updateDatoForDriftAction(Request $request, Tiltag $tiltag) {
    $editForm = $this->createForm(new TiltagDatoForDriftType($tiltag), $tiltag, array(
      'action' => $this->generateUrl('tiltag_dato_for_drift_update', array('id' => $tiltag->getId())),
      'method' => 'PUT',
    ));

    $editForm->handleRequest($request);

    $this->flash->success('tiltag.confirmation.datofordriftupdated');

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

      $this->flash->success('tiltag.confirmation.deleted');
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
      ->add('submit', 'submit', array(
        'label' => 'Delete',
        'attr' => array(
          'class' => 'pinned',
        ),
      ))
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
    $form = $this->createForm(new $formClass($this->container, $detail), $detail, array(
      'action' => $this->generateUrl('tiltag_detail_create', array('id' => $tiltag->getId())),
      'method' => 'POST',
    ));

    $this->addCreate($form, $this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));

    return $form;
  }

  /**
   * Creates a new Detail entity from form data
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

      $this->flash->success('tiltagdetail.confirmation.created');
      if ($request->get('continue')) {
        return $this->redirect($this->generateUrl('tiltag_detail_edit', array('id' => $detail->getId())));
      }

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    }

    $template = $this->getDetailTemplate($detail, 'new');
    return $this->render($template, array(
      'entity' => $detail,
      'edit_form' => $form->createView(),
    ));
  }

  //---------------- TiltagDetail Batch Edit -------------------//

  private function createDetailBatchEditForm(Tiltag $tiltag, $detail) {
    // Null default values
    $detail->setTilvalgt(null);
    $detail->setIkkeElenaBerettiget(null);
    if(method_exists($detail, 'setIsoleringskappe')) {
      $detail->setIsoleringskappe(null);
    }
    if(method_exists($detail, 'setNyttiggjortVarme')) {
      $detail->setNyttiggjortVarme(null);
    }
    if(method_exists($detail, 'setGlasandel')) {
      $detail->setGlasandel(null);
    }

    $formClass = $this->getFormTypeClassName($detail, TRUE);
    $form = $this->createForm(new $formClass($this->container, $detail, TRUE), $detail, array(
      'action' => $this->generateUrl('tiltag_detail_batch', array('id' => $tiltag->getId())),
      'method' => 'POST',
    ));

    $batchEditDetailIds = array();
    foreach ($tiltag->getDetails() as $detail) {
      if($detail->isBatchEdit()) {
        $batchEditDetailIds[] = $detail->getId();
      }
    }

    $implodeIds = empty($batchEditDetailIds) ? '' : implode(",", $batchEditDetailIds);
    $numberOfDetails =  empty($batchEditDetailIds) ? 'valgte' : count($batchEditDetailIds);

    $form->add('batchEditIdArray', 'hidden', array('mapped' => FALSE, 'data' => $implodeIds));
    $form->add('submit', 'submit', array('label' => 'Opdater '.$numberOfDetails.' tiltag'));

    return $form;
  }

  /**
   * Updates a batch of details
   *
   * @Route("/{id}/detailbatch", name="tiltag_detail_batch")
   * @Method("POST")
   * @Template()
   * @Security("is_granted('TILTAG_EDIT', tiltag)")
   */
  public function batchEditDetailAction(Request $request, Tiltag $tiltag) {
    // Use createform to validate data
    $formDetail = $this->createDetailEntity($tiltag);
    $formDetail->setBatchEdit(true);
    $form = $this->createDetailBatchEditForm($tiltag, $formDetail);

    $form->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    $detailsId = $form->get('batchEditIdArray')->getData();
    $detailsIdArray = explode(',', $detailsId);

    if ($form->isValid()) {
      $details = $em->getRepository('AppBundle:TiltagDetail')->findById($detailsIdArray);

      foreach ($details as $detail) {
        if($tiltag->getDetails()->contains($detail)) {
          $detail->updateProperties($formDetail);
        }
      }

      $em->flush();

      $this->flash->success('tiltagdetail.confirmation.batch_edited');

      return $this->redirect($this->generateUrl('tiltag_show', array('id' => $tiltag->getId())));
    }

    $this->setBreadcrumb($tiltag);
    $type = strtolower($this->getEntityName($tiltag));
    $this->breadcrumbs->addItem($type.'detail.actions.batch_edit', $this->get('router')->generate('tiltag_detail_batch', array('id' => $tiltag->getId())));

    $template = $this->getDetailTemplate($formDetail, 'new');
    return $this->render($template, array(
      'entity' => $formDetail,
      'edit_form' => $form->createView(),
    ));
  }

  //---------------- Helpers -------------------//

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
