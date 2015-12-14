<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\NyttiggjortVarme;
use AppBundle\Form\NyttiggjortVarmeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * NyttiggjortVarme controller.
 *
 * @Route("/nyttiggjortvarme")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class NyttiggjortVarmeController extends Controller
{

    /**
     * Lists all NyttiggjortVarme entities.
     *
     * @Route("/", name="nyttiggjortvarme")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:NyttiggjortVarme')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new NyttiggjortVarme entity.
     *
     * @Route("/", name="nyttiggjortvarme_create")
     * @Method("POST")
     * @Template("AppBundle:NyttiggjortVarme:new.html.twig")
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

            return $this->redirect($this->generateUrl('nyttiggjortvarme_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a NyttiggjortVarme entity.
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

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new NyttiggjortVarme entity.
     *
     * @Route("/new", name="nyttiggjortvarme_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NyttiggjortVarme();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a NyttiggjortVarme entity.
     *
     * @Route("/{id}", name="nyttiggjortvarme_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:NyttiggjortVarme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NyttiggjortVarme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NyttiggjortVarme entity.
     *
     * @Route("/{id}/edit", name="nyttiggjortvarme_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:NyttiggjortVarme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NyttiggjortVarme entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a NyttiggjortVarme entity.
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

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NyttiggjortVarme entity.
     *
     * @Route("/{id}", name="nyttiggjortvarme_update")
     * @Method("PUT")
     * @Template("AppBundle:NyttiggjortVarme:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:NyttiggjortVarme')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NyttiggjortVarme entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('nyttiggjortvarme_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a NyttiggjortVarme entity.
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
            $entity = $em->getRepository('AppBundle:NyttiggjortVarme')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NyttiggjortVarme entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('nyttiggjortvarme'));
    }

    /**
     * Creates a form to delete a NyttiggjortVarme entity by id.
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
