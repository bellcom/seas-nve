<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use AppBundle\DBAL\Types\BygningStatusType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Bygning;
use AppBundle\Form\Type\BygningType;
use AppBundle\Form\Type\BygningRaportType;
use AppBundle\Form\Type\BygningSearchType;
use AppBundle\Entity\Rapport;
use AppBundle\Form\Type\RapportType;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Bygning controller.
 *
 * @Route("/bygning/{id}/tilknytraadgiver")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class BygningAaPlusVerificeret extends BaseController implements InitControllerInterface {

  protected $breadcrumbs;

  public function init(Request $request)
  {
    parent::init($request);
    $this->breadcrumbs->addItem('Bygninger', $this->generateUrl('bygning'));
  }

  /**
   * Lists all Bygning entities.
   *
   * @Route("/", name="bygning_tilknyt")
   * @Method("GET")
   * @Template()
   */
  public function indexAction(Bygning $bygning) {
    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    $this->breadcrumbs->addItem('bygninger.actions.indfoer');

    //Set next status to trigger validation group
    $bygning->setStatus(BygningStatusType::TILKNYTTET_RAADGIVER);

    if(!$bygning->getRapport()) {
      $bygning->setRapport(new Rapport());
    }

    $editForm = $this->createEditForm($bygning);

    return array(
      'entity' => $bygning,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Edits an existing Bygning entity.
   *
   * @Route("/", name="bygning_tilknyt_update")
   * @Method("PUT")
   * @Template("AppBundle:BygningIndfoer:index.html.twig")
   */
  public function updateAction(Request $request, Bygning $bygning) {
    if(!$bygning->getRapport()) {
      $rapport = new Rapport();
      $rapport->setBygning($bygning);
    }

    $editForm = $this->createEditForm($bygning);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->flush();

      $this->flash->success('bygninger.confirmation.raadgiver_tilknyttet');

      return $this->redirect($this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    }

    $this->flash->error('common.form_error');

    return array(
      'entity' => $bygning,
      'edit_form' => $editForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Bygning entity.
   *
   * @param Bygning $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Bygning $entity) {
    $form = $this->createForm(new BygningRaportType($this->getDoctrine(), $this->get('security.context')), $entity, array(
      'action' => $this->generateUrl('bygning_tilknyt_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('bygning_show', array('id' => $entity->getId())));

    return $form;
  }

}
