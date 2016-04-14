<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Klimaskaerm;
use AppBundle\Form\Type\KlimaskaermType;
use AppBundle\Controller\BaseController;

/**
 * Klimaskaerm controller.
 *
 * @Route("/klimaskaerm")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class KlimaskaermController extends BaseController
{

  public function init(Request $request) {
    parent::init($request);
    $this->breadcrumbs->addItem('klimaskaerm.labels.singular', $this->generateUrl('klimaskaerm'));
}


    /**
     * Lists all Klimaskaerm entities.
     *
     * @Route("/", name="klimaskaerm")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Klimaskaerm')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Klimaskaerm entity.
     *
     * @Route("/", name="klimaskaerm_create")
     * @Method("POST")
     * @Template("AppBundle:Klimaskaerm:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Klimaskaerm();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('klimaskaerm'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Klimaskaerm entity.
     *
     * @param Klimaskaerm $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Klimaskaerm $entity)
    {
        $form = $this->createForm(new KlimaskaermType(), $entity, array(
            'action' => $this->generateUrl('klimaskaerm_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('klimaskaerm'));

        return $form;
    }

    /**
     * Displays a form to create a new Klimaskaerm entity.
     *
     * @Route("/new", name="klimaskaerm_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('klimaskaerm'));

        $entity = new Klimaskaerm();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Klimaskaerm entity.
     *
     * @Route("/{id}", name="klimaskaerm_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Klimaskaerm')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('klimaskaerm_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Klimaskaerm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Klimaskaerm entity.
     *
     * @Route("/{id}/edit", name="klimaskaerm_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Klimaskaerm $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('klimaskaerm_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('klimaskaerm_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Klimaskaerm entity.');
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
    * Creates a form to edit a Klimaskaerm entity.
    *
    * @param Klimaskaerm $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Klimaskaerm $entity)
    {
        $form = $this->createForm(new KlimaskaermType(), $entity, array(
            'action' => $this->generateUrl('klimaskaerm_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('klimaskaerm_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing Klimaskaerm entity.
     *
     * @Route("/{id}", name="klimaskaerm_update")
     * @Method("PUT")
     * @Template("AppBundle:Klimaskaerm:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Klimaskaerm')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Klimaskaerm entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('klimaskaerm'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Klimaskaerm entity.
     *
     * @Route("/{id}", name="klimaskaerm_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Klimaskaerm')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Klimaskaerm entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('klimaskaerm'));
    }

    /**
     * Creates a form to delete a Klimaskaerm entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Klimaskaerm');
        $klimaskaerm = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($klimaskaerm);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('klimaskaerm_delete', array('id' => $id)))
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
