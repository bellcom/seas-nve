<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use AppBundle\Entity\UserRepository;
use AppBundle\Form\Type\GroupRolesType;
use AppBundle\Form\Type\GroupType;
use FOS\UserBundle\Model\GroupInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Group controller.
 *
 * @Route("user/group")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class GroupController extends BaseController
{

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('user.labels.plural', $this->generateUrl('user'));
        $this->breadcrumbs->addItem('group.labels.plural', $this->generateUrl('group_list'));
    }

    /**
     * Lists all User entities.
     *
     * @Route("/", name="group_list")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Group')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="group_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        /** @var $groupManager \FOS\UserBundle\Model\GroupManagerInterface */
        $groupManager = $this->get('fos_user.group_manager');
        $entity = $groupManager->createGroup('');
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('group_new'));
        $form   = $this->createCreateForm($entity);
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pumpe entity.
     *
     * @param GroupInterface $entity
     *   New group entity.
     *
     * @return Form
     *   The form object.
     */
    private function createCreateForm($entity) {
        $form = $this->createForm(new GroupType(), $entity, array(
            'action' => $this->generateUrl('group_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('group_list'));
        return $form;
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/", name="group_create")
     * @Method("POST")
     * @Template("AppBundle:Group:new.html.twig")
     */
    public function createAction(Request $request) {
        /** @var $groupManager \FOS\Us erBundle\Model\GroupManagerInterface */
        $groupManager = $this->get('fos_user.group_manager');
        /** @var $entity GroupInterface */
        $entity = $groupManager->createGroup('');
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('group_list'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}", name="group_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        /** @var GroupInterface $entity */
        $entity = $em->getRepository('AppBundle:Group')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('group_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $roles_form = $this->createRolesEditForm($entity);
        $roles = Group::getAllRoles();
        return array(
            'entity'      => $entity,
            'roles_form'  => $roles_form->createView(),
            'roles'       => $roles,
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="group_edit")
     * @Method("GET")
     * @Template()
     *
     * @param Group $entity
     *   Group entity.
     *
     * @return array
     *   Response array.
     */
    public function editAction(Group $entity) {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('group_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('group_edit', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $edit_form = $this->createEditForm($entity);
        $delete_form = $this->createDeleteForm($entity->getId());
        return array(
            'entity'      => $entity,
            'edit_form'   => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * Creates a form to edit a Group entity.
     *
     * @param GroupInterface $entity
     *   The entity.
     *
     * @return Form
     *   The form.
     */
    private function createEditForm(GroupInterface $entity) {
        $form = $this->createForm(new GroupType(), $entity, array(
            'action' => $this->generateUrl('group_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('group_show', array('id' => $entity->getId())));
        return $form;
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}", name="group_update")
     * @Method("PUT")
     * @Template("AppBundle:Group:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Group')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $delete_form = $this->createDeleteForm($id);
        $edit_form = $this->createEditForm($entity);
        $edit_form->handleRequest($request);

        if ($edit_form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('group_list'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        );
    }

    /**
     * Creates a form to edit roles for Group entity.
     *
     * @param GroupInterface $entity
     *   The entity.
     *
     * @return Form
     *   The form.
     */
    private function createRolesEditForm(GroupInterface $entity) {
        $roles_form = $this->createForm(new GroupRolesType($this->container), $entity, array(
            'action' => $this->generateUrl('group_update_roles', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $this->addUpdate($roles_form);
        return $roles_form;
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}/roles", name="group_update_roles")
     * @Method("PUT")
     * @Template("AppBundle:Group:show.html.twig")
     */
    public function updateRolesAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        /** @var GroupInterface $entity */
        $entity = $em->getRepository('AppBundle:Group')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $roles_form = $this->createRolesEditForm($entity);
        $roles_form->handleRequest($request);

        if ($roles_form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('group_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'roles_form'  => $roles_form->createView(),
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}", name="group_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Group')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Group entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('group_list'));
    }

    /**
     * Creates a form to delete a Group entity by id.
     *
     * @param mixed $id
     *   The entity id.
     *
     * @return Form
     *   The form.
     */
    private function createDeleteForm($id) {
        $em = $this->getDoctrine()->getManager();
        /** @var UserRepository $repository */
        $repository = $em->getRepository('AppBundle:User');
        $users = $repository->getByGroupId($id);
        $message = NULL;
        if (!empty($users)) {
            $message = 'group.error.in_use';
        }
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('group_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'disabled' => $message,
                'attr' => array(
                    'disabled_message' => $message,
                ),
            ))
            ->getForm();
    }

}
