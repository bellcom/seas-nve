<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\PumpeDetail;
use AppBundle\Form\PumpeDetailType;

/**
 * PumpeDetail controller.
 *
 * @Route("/pumpedetail")
 */
class PumpeDetailController extends Controller
{

    /**
     * Lists all PumpeDetail entities.
     *
     * @Route("/", name="pumpedetail")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:PumpeDetail')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PumpeDetail entity.
     *
     * @Route("/", name="pumpedetail_create")
     * @Method("POST")
     * @Template("AppBundle:PumpeDetail:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PumpeDetail();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pumpedetail_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PumpeDetail entity.
     *
     * @param PumpeDetail $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PumpeDetail $entity)
    {
        $form = $this->createForm(new PumpeDetailType(), $entity, array(
            'action' => $this->generateUrl('pumpedetail_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PumpeDetail entity.
     *
     * @Route("/new", name="pumpedetail_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PumpeDetail();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PumpeDetail entity.
     *
     * @Route("/{id}", name="pumpedetail_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PumpeDetail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PumpeDetail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PumpeDetail entity.
     *
     * @Route("/{id}/edit", name="pumpedetail_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PumpeDetail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PumpeDetail entity.');
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
    * Creates a form to edit a PumpeDetail entity.
    *
    * @param PumpeDetail $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PumpeDetail $entity)
    {
        $form = $this->createForm(new PumpeDetailType(), $entity, array(
            'action' => $this->generateUrl('pumpedetail_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PumpeDetail entity.
     *
     * @Route("/{id}", name="pumpedetail_update")
     * @Method("PUT")
     * @Template("AppBundle:PumpeDetail:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:PumpeDetail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PumpeDetail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pumpedetail_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PumpeDetail entity.
     *
     * @Route("/{id}", name="pumpedetail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:PumpeDetail')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PumpeDetail entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pumpedetail'));
    }

    /**
     * Creates a form to delete a PumpeDetail entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pumpedetail_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
