<?php

namespace AppBundle\Controller\BelysningTiltagDetail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\BelysningTiltagDetail\Lyskilde;
use AppBundle\Form\BelysningTiltagDetail\LyskildeType;
use AppBundle\Controller\BaseController;

/**
 * BelysningTiltagDetail\Lyskilde controller.
 *
 * @Route("/belysningtiltagdetail_lyskilde")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class LyskildeController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('lyskilde.labels.singular', $this->generateUrl('belysningtiltagdetail_lyskilde'));
}


    /**
     * Lists all BelysningTiltagDetail\Lyskilde entities.
     *
     * @Route("/", name="belysningtiltagdetail_lyskilde")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:BelysningTiltagDetail\Lyskilde')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BelysningTiltagDetail\Lyskilde entity.
     *
     * @Route("/", name="belysningtiltagdetail_lyskilde_create")
     * @Method("POST")
     * @Template("AppBundle:BelysningTiltagDetail\Lyskilde:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lyskilde();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('belysningtiltagdetail_lyskilde'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BelysningTiltagDetail\Lyskilde entity.
     *
     * @param Lyskilde $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lyskilde $entity)
    {
        $form = $this->createForm(new LyskildeType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_lyskilde_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_lyskilde'));

        return $form;
    }

    /**
     * Displays a form to create a new BelysningTiltagDetail\Lyskilde entity.
     *
     * @Route("/new", name="belysningtiltagdetail_lyskilde_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('belysningtiltagdetail_lyskilde'));

        $entity = new Lyskilde();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BelysningTiltagDetail\Lyskilde entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_lyskilde_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\Lyskilde')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_lyskilde_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\Lyskilde entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BelysningTiltagDetail\Lyskilde entity.
     *
     * @Route("/{id}/edit", name="belysningtiltagdetail_lyskilde_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Lyskilde $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_lyskilde_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('belysningtiltagdetail_lyskilde_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\Lyskilde entity.');
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
    * Creates a form to edit a BelysningTiltagDetail\Lyskilde entity.
    *
    * @param Lyskilde $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lyskilde $entity)
    {
        $form = $this->createForm(new LyskildeType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_lyskilde_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_lyskilde_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing BelysningTiltagDetail\Lyskilde entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_lyskilde_update")
     * @Method("PUT")
     * @Template("AppBundle:BelysningTiltagDetail\Lyskilde:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\Lyskilde')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\Lyskilde entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('belysningtiltagdetail_lyskilde'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BelysningTiltagDetail\Lyskilde entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_lyskilde_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\Lyskilde')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\Lyskilde entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('belysningtiltagdetail_lyskilde'));
    }

    /**
     * Creates a form to delete a BelysningTiltagDetail\Lyskilde entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:BelysningTiltagDetail\Lyskilde');
        $lyskilde = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($lyskilde);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('belysningtiltagdetail_lyskilde_delete', array('id' => $id)))
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
