<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Form\Type\ForsyningsvaerkType;
use AppBundle\Controller\BaseController;

/**
 * Forsyningsvaerk controller.
 *
 * @Route("/forsyningsvaerk")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ForsyningsvaerkController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('forsyningsvaerk.labels.plural', $this->generateUrl('forsyningsvaerk'));
}


    /**
     * Lists all Forsyningsvaerk entities.
     *
     * @Route("/", name="forsyningsvaerk")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Forsyningsvaerk')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Forsyningsvaerk entity.
     *
     * @Route("/", name="forsyningsvaerk_create")
     * @Method("POST")
     * @Template("AppBundle:Forsyningsvaerk:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Forsyningsvaerk();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('forsyningsvaerk'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Forsyningsvaerk entity.
     *
     * @param Forsyningsvaerk $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Forsyningsvaerk $entity)
    {
        $form = $this->createForm(new ForsyningsvaerkType(), $entity, array(
            'action' => $this->generateUrl('forsyningsvaerk_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('forsyningsvaerk'));

        return $form;
    }

    /**
     * Displays a form to create a new Forsyningsvaerk entity.
     *
     * @Route("/new", name="forsyningsvaerk_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('forsyningsvaerk'));

        $entity = new Forsyningsvaerk();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Forsyningsvaerk entity.
     *
     * @Route("/{id}", name="forsyningsvaerk_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Forsyningsvaerk')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('forsyningsvaerk_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Forsyningsvaerk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Forsyningsvaerk entity.
     *
     * @Route("/{id}/edit", name="forsyningsvaerk_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Forsyningsvaerk $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('forsyningsvaerk_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('forsyningsvaerk_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Forsyningsvaerk entity.');
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
    * Creates a form to edit a Forsyningsvaerk entity.
    *
    * @param Forsyningsvaerk $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Forsyningsvaerk $entity)
    {
        $form = $this->createForm(new ForsyningsvaerkType(), $entity, array(
            'action' => $this->generateUrl('forsyningsvaerk_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('forsyningsvaerk_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing Forsyningsvaerk entity.
     *
     * @Route("/{id}", name="forsyningsvaerk_update")
     * @Method("PUT")
     * @Template("AppBundle:Forsyningsvaerk:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Forsyningsvaerk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Forsyningsvaerk entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('forsyningsvaerk'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Forsyningsvaerk entity.
     *
     * @Route("/{id}", name="forsyningsvaerk_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Forsyningsvaerk')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Forsyningsvaerk entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('forsyningsvaerk'));
    }

    /**
     * Creates a form to delete a Forsyningsvaerk entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Forsyningsvaerk');
        $entity = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($entity);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forsyningsvaerk_delete', array('id' => $id)))
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
