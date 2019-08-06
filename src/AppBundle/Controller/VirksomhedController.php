<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\VirksomhedFilterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Virksomhed;
use AppBundle\Form\VirksomhedType;
use AppBundle\Controller\BaseController;

/**
 * Virksomhed controller.
 *
 * @Route("/virksomhed")
 * @Security("has_role('ROLE_ADMIN')")
 */
class VirksomhedController extends BaseController
{

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('virksomhed.labels.plural', $this->generateUrl('virksomhed'));
    }

    /**
     * Lists all Virksomhed entities.
     *
     * @Route("/", name="virksomhed")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $virksomhed = new Virksomhed();
        $form = $this->createSearchForm($virksomhed);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $this->breadcrumbs->addItem('Søg', $this->generateUrl('virksomhed'));
        }

        // initialize a query builder
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:virksomhed')
            ->createQueryBuilder('v');

        // build the query from the given form object
        $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

        $pagination = $this->get('knp_paginator')->paginate(
            $filterBuilder->getQuery(),
            $request->query->get('page', 1),
            20
        );
        return $this->render(
            'AppBundle:Virksomhed:index.html.twig',
            array(
                'pagination' => $pagination,
                'form' => $form->createView(),
            )
        );

    }

    /**
     * Creates a form to search Bygning entities.
     *
     * @param Virksomhed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Virksomhed $entity) {
        $form = $this->createForm(new VirksomhedFilterType(), $entity, array(
            'action' => $this->generateUrl('virksomhed'),
            'method' => 'GET',
        ));

        return $form;
    }

    /**
     * Creates a new Virksomhed entity.
     *
     * @Route("/", name="virksomhed_create")
     * @Method("POST")
     * @Template("AppBundle:Virksomhed:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Virksomhed();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('virksomhed'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Virksomhed entity.
     *
     * @param Virksomhed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Virksomhed $entity)
    {
        $form = $this->createForm(new VirksomhedType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed'));

        return $form;
    }

    /**
     * Displays a form to create a new Virksomhed entity.
     *
     * @Route("/new", name="virksomhed_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('virksomhed'));

        $entity = new Virksomhed();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Virksomhed entity.
     *
     * @Route("/{id}", name="virksomhed_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Virksomhed')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Virksomhed entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Virksomhed entity.
     *
     * @Route("/{id}/edit", name="virksomhed_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Virksomhed $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Virksomhed entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Virksomhed entity.
    *
    * @param Virksomhed $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Virksomhed $entity)
    {
        $form = $this->createForm(new VirksomhedType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing Virksomhed entity.
     *
     * @Route("/{id}", name="virksomhed_update")
     * @Method("PUT")
     * @Template("AppBundle:Virksomhed:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Virksomhed')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Virksomhed entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('virksomhed'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Virksomhed entity.
     *
     * @Route("/{id}", name="virksomhed_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Virksomhed')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Virksomhed entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('virksomhed'));
    }

    /**
     * Creates a form to delete a Virksomhed entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Bygning');
        $bygnings = $repository->findBy(array('virksomhed' => $id));
        $message = NULL;
        if (!empty($bygnings)) {
            $message = 'virksomhed.error.in_use';
        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('virksomhed_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'disabled' => $message,
                'attr' => array(
                    'disabled_message' => $message,
                ),
            ))
            ->getForm()
        ;
    }
}
