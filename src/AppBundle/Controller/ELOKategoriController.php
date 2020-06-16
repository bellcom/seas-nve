<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\ELOKategori;
use AppBundle\Form\ELOKategoriType;
use AppBundle\Controller\BaseController;

/**
 * ELOKategori controller.
 *
 * @Route("/elokategori")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ELOKategoriController extends BaseController
{

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('elokategori.labels.singular', $this->generateUrl('elokategori'));
    }

    /**
     * Lists all ELOKategori entities.
     *
     * @Route("/", name="elokategori")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ELOKategori')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ELOKategori entity.
     *
     * @Route("/", name="elokategori_create")
     * @Method("POST")
     * @Template("AppBundle:ELOKategori:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ELOKategori();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('elokategori'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ELOKategori entity.
     *
     * @param ELOKategori $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ELOKategori $entity)
    {
        $form = $this->createForm(new ELOKategoriType(), $entity, array(
            'action' => $this->generateUrl('elokategori_create'),
            'method' => 'POST',
        ));

        $this->addCreate($form, $this->generateUrl('elokategori'));

        return $form;
    }

    /**
     * Displays a form to create a new ELOKategori entity.
     *
     * @Route("/new", name="elokategori_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('elokategori'));

        $entity = new ELOKategori();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ELOKategori entity.
     *
     * @Route("/{id}", name="elokategori_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ELOKategori')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('elokategori_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ELOKategori entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ELOKategori entity.
     *
     * @Route("/{id}/edit", name="elokategori_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(ELOKategori $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('elokategori_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('elokategori_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ELOKategori entity.');
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
    * Creates a form to edit a ELOKategori entity.
    *
    * @param ELOKategori $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ELOKategori $entity)
    {
        $form = $this->createForm(new ELOKategoriType(), $entity, array(
            'action' => $this->generateUrl('elokategori_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('elokategori'));
        $this->addUpdateAndExit($form, $this->generateUrl('elokategori'));

        return $form;
    }
    /**
     * Edits an existing ELOKategori entity.
     *
     * @Route("/{id}/edit", name="elokategori_update")
     * @Method("PUT")
     * @Template("AppBundle:ELOKategori:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ELOKategori')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ELOKategori entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->flash->success('elokategori.confirmation.updated');

            $destination = $request->getRequestUri();
            if ($button_destination = $this->getButtonDestination($editForm->getClickedButton())) {
                $destination = $button_destination;
            }
            return $this->redirect($destination);
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ELOKategori entity.
     *
     * @Route("/{id}", name="elokategori_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ELOKategori')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ELOKategori entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('elokategori'));
    }

    /**
     * Creates a form to delete a ELOKategori entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('elokategori_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
              'label' => 'Delete',
              'attr' => array(
                'class' => 'pinned',
              ),
            ))
            ->getForm()
        ;
    }
}
