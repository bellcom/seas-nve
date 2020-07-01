<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ForsyningsvaerkSearchType;
use AppBundle\Form\VirksomhedType;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Forsyningsvaerk;
use AppBundle\Form\Type\ForsyningsvaerkType;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Forsyningsvaerk controller.
 *
 * @Route("/forsyningsvaerk")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class ForsyningsvaerkController extends BaseController
{
  /**
   * @var Request
   */
  protected $request;

  public function init(Request $request) {
    $this->request = $request;
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
    public function indexAction(Request $request)
    {
        $entity = new Forsyningsvaerk();
        $form = $this->createSearchForm($entity);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
          $this->breadcrumbs->addItem('Søg', $this->generateUrl('bygning'));
        }

        $em = $this->getDoctrine()->getManager();

        $search = array();

        $search['navn'] = $entity->getNavn();
        $search['energiform'] = $entity->getEnergiform();
        $entities = $em->getRepository('AppBundle:Forsyningsvaerk')->search($search);
        return array(
            'entities' => $entities,
            'form' => $form->createView(),
            'forsyningvaerk_search' => array_filter($search),
        );
    }

    /**
     * Creates a form to search Rapport entities.
     *
     * @param Forsyningsvaerk $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSearchForm(Forsyningsvaerk $entity) {
      $form = $this->createForm(new ForsyningsvaerkSearchType(), $entity, array(
        'action' => $this->generateUrl('forsyningsvaerk'),
        'method' => 'GET',
      ));

      return $form;
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

        $this->addCreate($form, $this->generateUrl('forsyningsvaerk'));

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
        $params = array('id' => $entity->getId());

        // Getting desired destination for form redirect.
        $destination = $this->generateUrl('forsyningsvaerk');
        if ($this->request->get('destination')) {
            $destination = $this->request->get('destination');
            $params['destination'] = $destination;
        }
        $form = $this->createForm(new ForsyningsvaerkType(), $entity, array(
            'action' => $this->generateUrl('forsyningsvaerk_update', $params),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $destination);
        $this->addUpdateAndExit($form, $destination);

        return $form;
    }
    /**
     * Edits an existing Forsyningsvaerk entity.
     *
     * @Route("/{id}/edit", name="forsyningsvaerk_update")
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

            $this->flash->success('forsyningsvaerk.confirmation.updated');

            $destination = $request->getRequestUri();
            if ($button_destination = $this->getButtonDestination($editForm)) {
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
                    'class' => 'pinned',
                ),
            ))
            ->getForm()
        ;
    }
}
