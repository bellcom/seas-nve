<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Leverandoer;
use AppBundle\Form\Type\LeverandoerType;

/**
 * Leverandoer controller.
 *
 * @Route("/leverandoer")
 */
class LeverandoerController extends BaseController
{

    /**
     * Lists all Leverandoer entities.
     *
     * @Route("/", name="leverandoer")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Leverandoer')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Leverandoer entity.
     *
     * @Route("/", name="leverandoer_create")
     * @Method("POST")
     * @Template("AppBundle:Leverandoer:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Leverandoer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('leverandoer_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Leverandoer entity.
     *
     * @param Leverandoer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Leverandoer $entity)
    {
        $form = $this->createForm(new LeverandoerType(), $entity, array(
            'action' => $this->generateUrl('leverandoer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Leverandoer entity.
     *
     * @Route("/new", name="leverandoer_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Leverandoer();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Leverandoer entity.
     *
     * @Route("/{id}", name="leverandoer_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Leverandoer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leverandoer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Leverandoer entity.
     *
     * @Route("/{id}/edit", name="leverandoer_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Leverandoer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leverandoer entity.');
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
    * Creates a form to edit a Leverandoer entity.
    *
    * @param Leverandoer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Leverandoer $entity)
    {
        $form = $this->createForm(new LeverandoerType(), $entity, array(
            'action' => $this->generateUrl('leverandoer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Leverandoer entity.
     *
     * @Route("/{id}", name="leverandoer_update")
     * @Method("PUT")
     * @Template("AppBundle:Leverandoer:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Leverandoer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Leverandoer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('leverandoer_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Leverandoer entity.
     *
     * @Route("/{id}", name="leverandoer_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Leverandoer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Leverandoer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('leverandoer'));
    }

    /**
     * Creates a form to delete a Leverandoer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('leverandoer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
