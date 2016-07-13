<?php

namespace AppBundle\Controller\BelysningTiltagDetail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\BelysningTiltagDetail\NytArmatur;
use AppBundle\Form\BelysningTiltagDetail\NytArmaturType;
use AppBundle\Controller\BaseController;

/**
 * BelysningTiltagDetail\NytArmatur controller.
 *
 * @Route("/belysningtiltagdetail_nytarmatur")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class NytArmaturController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('nytArmatur.labels.singular', $this->generateUrl('belysningtiltagdetail_nytarmatur'));
}


    /**
     * Lists all BelysningTiltagDetail\NytArmatur entities.
     *
     * @Route("/", name="belysningtiltagdetail_nytarmatur")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/", name="belysningtiltagdetail_nytarmatur_create")
     * @Method("POST")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NytArmatur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BelysningTiltagDetail\NytArmatur entity.
     *
     * @param NytArmatur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NytArmatur $entity)
    {
        $form = $this->createForm(new NytArmaturType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_nytarmatur_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_nytarmatur'));

        return $form;
    }

    /**
     * Displays a form to create a new BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/new", name="belysningtiltagdetail_nytarmatur_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('belysningtiltagdetail_nytarmatur'));

        $entity = new NytArmatur();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_nytarmatur_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}/edit", name="belysningtiltagdetail_nytarmatur_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(NytArmatur $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
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
    * Creates a form to edit a BelysningTiltagDetail\NytArmatur entity.
    *
    * @param NytArmatur $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NytArmatur $entity)
    {
        $form = $this->createForm(new NytArmaturType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_nytarmatur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_nytarmatur_update")
     * @Method("PUT")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_nytarmatur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));
    }

    /**
     * Creates a form to delete a BelysningTiltagDetail\NytArmatur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur');
        $nytarmatur = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($nytarmatur);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('belysningtiltagdetail_nytarmatur_delete', array('id' => $id)))
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
