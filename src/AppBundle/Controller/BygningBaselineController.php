<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bygning;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Baseline;
use AppBundle\Form\BaselineType;
use AppBundle\Controller\BaseController;

/**
 * Baseline controller.
 *
 * @Route("bygning/{id}/baseline")
 */
class BygningBaselineController extends BaseController {

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('Bygninger', $this->generateUrl('bygning'));
  }

  /**
   * Finds and displays a Baseline entity.
   *
   * @Route("/", name="bygning_baseline_show")
   * @Method("GET")
   * @Template()
   */
  public function showAction(Bygning $bygning) {
    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning_show', array('id' => $bygning->getId())));

    if (!$bygning) {
      throw $this->createNotFoundException('Unable to find Baseline entity.');
    }

    return array(
      'entity' => $bygning->getBaseline(),
    );
  }

  /**
   * Displays a form to edit an existing Baseline entity.
   *
   * @Route("/edit", name="bygning_baseline_edit")
   * @Method("GET")
   * @Template()
   */
  public function editAction(Bygning $bygning) {
    $this->breadcrumbs->addItem($bygning, $this->generateUrl('bygning_show', array('id' => $bygning->getId())));
    $this->breadcrumbs->addItem('appbundle.bygning.baseline', $this->generateUrl('bygning_show', array('id' => $bygning->getId())));

    if(!$bygning->getBaseline()) {
      $bygning->setBaseline(new Baseline());
    }

    $GDNormalAar = "";
    $normtal = $this->container->get('doctrine')->getRepository('AppBundle:GraddageFordeling')->findOneByTitel('Normtal');
    if ($normtal) {
      $GDNormalAar = $normtal->getSumAar();
    }

    if (!$bygning) {
      throw $this->createNotFoundException('Unable to find Bygning entity.');
    }

    $editForm = $this->createEditForm($bygning->getBaseline());

    return array(
      'entity' => $bygning->getBaseline(),
      'edit_form' => $editForm->createView(),
      'graddage_normal' => $GDNormalAar,
    );
  }

  /**
   * Creates a form to edit a Baseline entity.
   *
   * @param Baseline $baseline The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Baseline $baseline) {
    $form = $this->createForm(new BaselineType(), $baseline, array(
      'action' => $this->generateUrl('bygning_baseline_update', array('id' => $baseline->getBygning()->getId())),
      'method' => 'PUT',
    ));

    $this->addUpdate($form, $this->generateUrl('bygning_baseline_show', array('id' => $baseline->getBygning()->getId())));

    return $form;
  }

  /**
   * Edits an existing Baseline entity.
   *
   * @Route("/", name="bygning_baseline_update")
   * @Method("PUT")
   * @Template("AppBundle:Baseline:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();
    $bygning = $em->getRepository('AppBundle:Bygning')->find($id);
    if(!$bygning->getBaseline()) {
      $bygning->setBaseline(new Baseline());
    }

    if (!$bygning) {
      throw $this->createNotFoundException('Unable to find Bygning entity.');
    }

    $editForm = $this->createEditForm($bygning->getBaseline());
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('bygning_baseline_edit', array('id' => $bygning->getId())));
    }

    return array(
      'entity' => $bygning,
      'edit_form' => $editForm->createView(),
    );
  }

}
