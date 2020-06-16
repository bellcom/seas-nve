<?php

namespace AppBundle\Controller\TekniskIsoleringTiltagDetail;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\TekniskIsoleringTiltagDetail\Komponent;
use AppBundle\Form\TekniskIsoleringTiltagDetail\KomponentType;
use AppBundle\Controller\BaseController;

/**
 * TekniskIsoleringTiltagDetail\Komponent controller.
 *
 * @Route("/komponent")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class KomponentController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('komponent.labels.singular', $this->generateUrl('komponent'));
}


    /**
     * Lists all TekniskIsoleringTiltagDetail\Komponent entities.
     *
     * @Route("/", name="komponent")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\Komponent')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @Route("/", name="komponent_create")
     * @Method("POST")
     * @Template("AppBundle:TekniskIsoleringTiltagDetail\Komponent:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Komponent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('komponent'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @param Komponent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Komponent $entity)
    {
        $form = $this->createForm(new KomponentType(), $entity, array(
            'action' => $this->generateUrl('komponent_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('komponent'));

        return $form;
    }

    /**
     * Displays a form to create a new TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @Route("/new", name="komponent_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('komponent'));

        $entity = new Komponent();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @Route("/{id}", name="komponent_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\Komponent')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('komponent_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\Komponent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @Route("/{id}/edit", name="komponent_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Komponent $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('komponent_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('komponent_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\Komponent entity.');
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
    * Creates a form to edit a TekniskIsoleringTiltagDetail\Komponent entity.
    *
    * @param Komponent $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Komponent $entity)
    {
        $form = $this->createForm(new KomponentType(), $entity, array(
            'action' => $this->generateUrl('komponent_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('komponent_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @Route("/{id}", name="komponent_update")
     * @Method("PUT")
     * @Template("AppBundle:TekniskIsoleringTiltagDetail\Komponent:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\Komponent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\Komponent entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('komponent'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TekniskIsoleringTiltagDetail\Komponent entity.
     *
     * @Route("/{id}", name="komponent_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:TekniskIsoleringTiltagDetail\Komponent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TekniskIsoleringTiltagDetail\Komponent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('komponent'));
    }

    /**
     * Creates a form to delete a TekniskIsoleringTiltagDetail\Komponent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:TekniskIsoleringTiltagDetail\Komponent');
        $komponent = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($komponent);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('komponent_delete', array('id' => $id)))
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
