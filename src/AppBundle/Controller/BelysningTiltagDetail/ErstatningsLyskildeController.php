<?php

namespace AppBundle\Controller\BelysningTiltagDetail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\BelysningTiltagDetail\ErstatningsLyskilde;
use AppBundle\Form\BelysningTiltagDetail\ErstatningsLyskildeType;
use AppBundle\Controller\BaseController;

/**
 * BelysningTiltagDetail\ErstatningsLyskilde controller.
 *
 * @Route("/belysningtiltagdetail_erstatningslyskilde")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ErstatningsLyskildeController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('erstatningslyskilde.labels.singular', $this->generateUrl('belysningtiltagdetail_erstatningslyskilde'));
}


    /**
     * Lists all BelysningTiltagDetail\ErstatningsLyskilde entities.
     *
     * @Route("/", name="belysningtiltagdetail_erstatningslyskilde")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:BelysningTiltagDetail\ErstatningsLyskilde')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @Route("/", name="belysningtiltagdetail_erstatningslyskilde_create")
     * @Method("POST")
     * @Template("AppBundle:BelysningTiltagDetail\ErstatningsLyskilde:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ErstatningsLyskilde();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('belysningtiltagdetail_erstatningslyskilde'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @param ErstatningsLyskilde $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ErstatningsLyskilde $entity)
    {
        $form = $this->createForm(new ErstatningsLyskildeType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_erstatningslyskilde_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_erstatningslyskilde'));

        return $form;
    }

    /**
     * Displays a form to create a new BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @Route("/new", name="belysningtiltagdetail_erstatningslyskilde_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('belysningtiltagdetail_erstatningslyskilde'));

        $entity = new ErstatningsLyskilde();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_erstatningslyskilde_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\ErstatningsLyskilde')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_erstatningslyskilde_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\ErstatningsLyskilde entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @Route("/{id}/edit", name="belysningtiltagdetail_erstatningslyskilde_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(ErstatningsLyskilde $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_erstatningslyskilde_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('belysningtiltagdetail_erstatningslyskilde_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\ErstatningsLyskilde entity.');
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
    * Creates a form to edit a BelysningTiltagDetail\ErstatningsLyskilde entity.
    *
    * @param ErstatningsLyskilde $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ErstatningsLyskilde $entity)
    {
        $form = $this->createForm(new ErstatningsLyskildeType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_erstatningslyskilde_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_erstatningslyskilde_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_erstatningslyskilde_update")
     * @Method("PUT")
     * @Template("AppBundle:BelysningTiltagDetail\ErstatningsLyskilde:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\ErstatningsLyskilde')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\ErstatningsLyskilde entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('belysningtiltagdetail_erstatningslyskilde'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BelysningTiltagDetail\ErstatningsLyskilde entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_erstatningslyskilde_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\ErstatningsLyskilde')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\ErstatningsLyskilde entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('belysningtiltagdetail_erstatningslyskilde'));
    }

    /**
     * Creates a form to delete a BelysningTiltagDetail\ErstatningsLyskilde entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:BelysningTiltagDetail\ErstatningsLyskilde');
        $erstatningslyskilde = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($erstatningslyskilde);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('belysningtiltagdetail_erstatningslyskilde_delete', array('id' => $id)))
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
