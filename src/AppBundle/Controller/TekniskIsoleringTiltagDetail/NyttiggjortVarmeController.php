<?php

namespace AppBundle\Controller\TekniskIsoleringTiltagDetail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\TekniskIsoleringTiltagDetail\NyttiggjortVarme;
use AppBundle\Form\TekniskIsoleringTiltagDetail\NyttiggjortVarmeType;
use AppBundle\Controller\BaseController;

/**
 * TekniskIsoleringTiltagDetail\NyttiggjortVarme controller.
 *
 * @Route("/nyttiggjortvarme")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class NyttiggjortVarmeController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('nyttiggjortvarme.labels.singular', $this->generateUrl('nyttiggjortvarme'));
}


    /**
     * Lists all TekniskIsoleringTiltagDetail\NyttiggjortVarme entities.
     *
     * @Route("/", name="nyttiggjortvarme")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\NyttiggjortVarme')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @Route("/", name="nyttiggjortvarme_create")
     * @Method("POST")
     * @Template("AppBundle:TekniskIsoleringTiltagDetail\NyttiggjortVarme:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NyttiggjortVarme();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('nyttiggjortvarme'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @param NyttiggjortVarme $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NyttiggjortVarme $entity)
    {
        $form = $this->createForm(new NyttiggjortVarmeType(), $entity, array(
            'action' => $this->generateUrl('nyttiggjortvarme_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('nyttiggjortvarme'));

        return $form;
    }

    /**
     * Displays a form to create a new TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @Route("/new", name="nyttiggjortvarme_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('nyttiggjortvarme'));

        $entity = new NyttiggjortVarme();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @Route("/{id}", name="nyttiggjortvarme_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\NyttiggjortVarme')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('nyttiggjortvarme_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @Route("/{id}/edit", name="nyttiggjortvarme_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(NyttiggjortVarme $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('nyttiggjortvarme_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('nyttiggjortvarme_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.');
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
    * Creates a form to edit a TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
    *
    * @param NyttiggjortVarme $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NyttiggjortVarme $entity)
    {
        $form = $this->createForm(new NyttiggjortVarmeType(), $entity, array(
            'action' => $this->generateUrl('nyttiggjortvarme_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('nyttiggjortvarme_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @Route("/{id}", name="nyttiggjortvarme_update")
     * @Method("PUT")
     * @Template("AppBundle:TekniskIsoleringTiltagDetail\NyttiggjortVarme:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\NyttiggjortVarme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('nyttiggjortvarme'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.
     *
     * @Route("/{id}", name="nyttiggjortvarme_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\NyttiggjortVarme')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\NyttiggjortVarme entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('nyttiggjortvarme'));
    }

    /**
     * Creates a form to delete a TekniskIsoleringTiltagDetail\NyttiggjortVarme entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('nyttiggjortvarme_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
