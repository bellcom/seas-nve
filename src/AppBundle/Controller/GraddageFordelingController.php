<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\GraddageFordeling;
use AppBundle\Form\GraddageFordelingType;
use AppBundle\Controller\BaseController;

/**
 * GraddageFordeling controller.
 *
 * @Route("/graddage")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class GraddageFordelingController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('graddagefordeling.labels.singular', $this->generateUrl('graddage'));
}


    /**
     * Lists all GraddageFordeling entities.
     *
     * @Route("/", name="graddage")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:GraddageFordeling')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new GraddageFordeling entity.
     *
     * @Route("/", name="graddage_create")
     * @Method("POST")
     * @Template("AppBundle:GraddageFordeling:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new GraddageFordeling();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('graddage'));

        }

        return array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a GraddageFordeling entity.
     *
     * @param GraddageFordeling $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GraddageFordeling $entity)
    {
        $form = $this->createForm(new GraddageFordelingType($entity), $entity, array(
            'action' => $this->generateUrl('graddage_create'),
            'method' => 'POST',
        ));

        $this->addCreate($form, $this->generateUrl('graddage'));

        return $form;
    }

    /**
     * Displays a form to create a new GraddageFordeling entity.
     *
     * @Route("/new", name="graddage_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('graddage'));

        $entity = new GraddageFordeling();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a GraddageFordeling entity.
     *
     * @Route("/{id}", name="graddage_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GraddageFordeling')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('graddage_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraddageFordeling entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing GraddageFordeling entity.
     *
     * @Route("/{id}/edit", name="graddage_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(GraddageFordeling $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('graddage_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('graddage_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraddageFordeling entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a GraddageFordeling entity.
    *
    * @param GraddageFordeling $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GraddageFordeling $entity)
    {
        $form = $this->createForm(new GraddageFordelingType($entity), $entity, array(
            'action' => $this->generateUrl('graddage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('graddage'));
        $this->addUpdateAndExit($form, $this->generateUrl('graddage'));

        return $form;
    }
    /**
     * Edits an existing GraddageFordeling entity.
     *
     * @Route("/{id}/edit", name="graddage_update")
     * @Method("PUT")
     * @Template("AppBundle:GraddageFordeling:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:GraddageFordeling')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GraddageFordeling entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->flash->success('graddagefordeling.confirmation.updated');

            $destination = $request->getRequestUri();
            if ($button_destination = $this->getButtonDestination($editForm)) {
                $destination = $button_destination;
            }
            return $this->redirect($destination);
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

}
