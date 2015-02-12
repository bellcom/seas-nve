<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Tiltag;
use AppBundle\Form\TiltagType;

/**
 * Tiltag controller.
 *
 * @Route("/tiltag")
 */
class TiltagController extends Controller
{

    /**
     * Lists all Tiltag entities.
     *
     * @Route("/", name="tiltag")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Tiltag')->findAll();

        /*
        return array(
            'entities' => $entities,
        );
        */

        return $this->render('AppBundle:Tiltag:index.html.twig', array(
          'tiltag' => $entities
        ));
    }


    /**
     * Creates a new Tiltag entity.
     *
     * @Route("/", name="tiltag_create")
     * @Method("POST")
     * @Template("AppBundle:Tiltag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Tiltag();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tiltag_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Creates a form to create a Tiltag entity.
     *
     * @param Tiltag $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tiltag $entity)
    {
        $form = $this->createForm(new TiltagType(), $entity, array(
            'action' => $this->generateUrl('tiltag_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to create a new Tiltag entity.
     *
     * @Route("/new", name="tiltag_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tiltag();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Finds and displays a Tiltag entity.
     *
     * @Route("/{id}", name="tiltag_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Tiltag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tiltag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Tiltag entity.
     *
     * @Route("/{id}/edit", name="tiltag_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Tiltag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tiltag entity.');
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
    * Creates a form to edit a Tiltag entity.
    *
    * @param Tiltag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Tiltag $entity)
    {
        $form = $this->createForm(new TiltagType(), $entity, array(
            'action' => $this->generateUrl('tiltag_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }


    /**
     * Edits an existing Tiltag entity.
     *
     * @Route("/{id}", name="tiltag_update")
     * @Method("PUT")
     * @Template("AppBundle:Tiltag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Tiltag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tiltag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('tiltag_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Deletes a Tiltag entity.
     *
     * @Route("/{id}", name="tiltag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Tiltag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tiltag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tiltag'));
    }


    /**
     * Creates a form to delete a Tiltag entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiltag_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
