<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\PumpeTiltagDetailApplikation;
use AppBundle\Form\PumpeTiltagDetailApplikationType;
use AppBundle\Controller\BaseController;

/**
 * PumpeTiltagDetailApplikation controller.
 *
 * @Route("/pumpetiltagdetailapplikation")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class PumpeTiltagDetailApplikationController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('pumpetiltagdetailapplikation.labels.singular', $this->generateUrl('pumpetiltagdetailapplikation'));
}


    /**
     * Lists all PumpeTiltagDetailApplikation entities.
     *
     * @Route("/", name="pumpetiltagdetailapplikation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:PumpeTiltagDetailApplikation')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PumpeTiltagDetailApplikation entity.
     *
     * @Route("/", name="pumpetiltagdetailapplikation_create")
     * @Method("POST")
     * @Template("AppBundle:PumpeTiltagDetailApplikation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PumpeTiltagDetailApplikation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->flash->success('pumpetiltagdetailapplikation.confirmation.created');

            return $this->redirect($this->generateUrl('pumpetiltagdetailapplikation'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PumpeTiltagDetailApplikation entity.
     *
     * @param PumpeTiltagDetailApplikation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PumpeTiltagDetailApplikation $entity)
    {
        $form = $this->createForm(new PumpeTiltagDetailApplikationType(), $entity, array(
            'action' => $this->generateUrl('pumpetiltagdetailapplikation_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('pumpetiltagdetailapplikation'));

        return $form;
    }

    /**
     * Displays a form to create a new PumpeTiltagDetailApplikation entity.
     *
     * @Route("/new", name="pumpetiltagdetailapplikation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('pumpetiltagdetailapplikation'));

        $entity = new PumpeTiltagDetailApplikation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PumpeTiltagDetailApplikation entity.
     *
     * @Route("/{id}", name="pumpetiltagdetailapplikation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PumpeTiltagDetailApplikation')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('pumpetiltagdetailapplikation_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PumpeTiltagDetailApplikation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PumpeTiltagDetailApplikation entity.
     *
     * @Route("/{id}/edit", name="pumpetiltagdetailapplikation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(PumpeTiltagDetailApplikation $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('pumpetiltagdetailapplikation_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('pumpetiltagdetailapplikation_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PumpeTiltagDetailApplikation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a PumpeTiltagDetailApplikation entity.
    *
    * @param PumpeTiltagDetailApplikation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PumpeTiltagDetailApplikation $entity)
    {
        $form = $this->createForm(new PumpeTiltagDetailApplikationType(), $entity, array(
            'action' => $this->generateUrl('pumpetiltagdetailapplikation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('pumpetiltagdetailapplikation_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing PumpeTiltagDetailApplikation entity.
     *
     * @Route("/{id}", name="pumpetiltagdetailapplikation_update")
     * @Method("PUT")
     * @Template("AppBundle:PumpeTiltagDetailApplikation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PumpeTiltagDetailApplikation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PumpeTiltagDetailApplikation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->flash->success('pumpetiltagdetailapplikation.confirmation.updated');
            return $this->redirect($this->generateUrl('pumpetiltagdetailapplikation'));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PumpeTiltagDetailApplikation entity.
     *
     * @Route("/{id}", name="pumpetiltagdetailapplikation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:PumpeTiltagDetailApplikation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PumpeTiltagDetailApplikation entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->flash->success('pumpetiltagdetailapplikation.confirmation.deleted');

        }

        return $this->redirect($this->generateUrl('pumpetiltagdetailapplikation'));
    }

    /**
     * Creates a form to delete a PumpeTiltagDetailApplikation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:PumpeTiltagDetail');
        $pumpetiltag = $repository->findBy(array('applikation' => $id));
        $message = NULL;
        if (!empty($pumpetiltag)) {
            $message = 'pumpetiltagdetailapplikation.error.in_use';
        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pumpetiltagdetailapplikation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'disabled' => $message,
                'attr' => array(
                    'disabled_message' => $message,
                    'class' => 'pinned',
                ),
            ))
            ->getForm()
        ;
    }
}
