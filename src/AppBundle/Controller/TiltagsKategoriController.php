<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\TiltagsKategori;
use AppBundle\Form\TiltagsKategoriType;
use AppBundle\Controller\BaseController;

/**
 * TiltagsKategori controller.
 *
 * @Route("/tiltagskategori")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class TiltagsKategoriController extends BaseController
{

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('tiltagskategori.labels.singular', $this->generateUrl('tiltagskategori'));
    }


    /**
     * Lists all TiltagsKategori entities.
     *
     * @Route("/", name="tiltagskategori")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:TiltagsKategori')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new TiltagsKategori entity.
     *
     * @Route("/", name="tiltagskategori_create")
     * @Method("POST")
     * @Template("AppBundle:TiltagsKategori:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new TiltagsKategori();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->flash->success('tiltagskategori.confirmation.created');

            return $this->redirect($this->generateUrl('tiltagskategori'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a TiltagsKategori entity.
     *
     * @param TiltagsKategori $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TiltagsKategori $entity)
    {
        $form = $this->createForm(new TiltagsKategoriType(), $entity, array(
            'action' => $this->generateUrl('tiltagskategori_create'),
            'method' => 'POST',
        ));

        $this->addCreate($form, $this->generateUrl('tiltagskategori'));

        return $form;
    }

    /**
     * Displays a form to create a new TiltagsKategori entity.
     *
     * @Route("/new", name="tiltagskategori_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('tiltagskategori'));

        $entity = new TiltagsKategori();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a TiltagsKategori entity.
     *
     * @Route("/{id}", name="tiltagskategori_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TiltagsKategori')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('tiltagskategori_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TiltagsKategori entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing TiltagsKategori entity.
     *
     * @Route("/{id}/edit", name="tiltagskategori_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(TiltagsKategori $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('tiltagskategori_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('tiltagskategori_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TiltagsKategori entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a TiltagsKategori entity.
    *
    * @param TiltagsKategori $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TiltagsKategori $entity)
    {
        $form = $this->createForm(new TiltagsKategoriType(), $entity, array(
            'action' => $this->generateUrl('tiltagskategori_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('tiltagskategori'));
        $this->addUpdateAndExit($form, $this->generateUrl('tiltagskategori'));

        return $form;
    }
    /**
     * Edits an existing TiltagsKategori entity.
     *
     * @Route("/{id}/edit", name="tiltagskategori_update")
     * @Method("PUT")
     * @Template("AppBundle:TiltagsKategori:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:TiltagsKategori')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TiltagsKategori entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->flash->success('tiltagskategori.confirmation.updated');

            $destination = $request->getRequestUri();
            if ($button_destination = $this->getButtonDestination($editForm->getClickedButton())) {
                $destination = $button_destination;
            }
            return $this->redirect($destination);
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a TiltagsKategori entity.
     *
     * @Route("/{id}", name="tiltagskategori_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:TiltagsKategori')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TiltagsKategori entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->flash->success('tiltagskategori.confirmation.deleted');
        }

        return $this->redirect($this->generateUrl('tiltagskategori'));
    }

    /**
     * Creates a form to delete a TiltagsKategori entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Tiltag');
        $tiltagDetail = $repository->findBy(array('tiltagskategori' => $id));
        $message = NULL;
        if (!empty($tiltagDetail)) {
            $message = 'tiltagskategori.error.in_use';
        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tiltagskategori_delete', array('id' => $id)))
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
