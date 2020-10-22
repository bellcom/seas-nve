<?php

namespace AppBundle\Controller\RapportSektioner;


use AppBundle\Entity\Virksomhed;
use AppBundle\Entity\RapportSektioner\RapportSektion;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Form\Type\RapportSektion\RapportSektionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

/**
 * VirksomhedOversigtSektionerController controller.
 *
 * @Route("/virksomhed/rapport/{virksomhed_rapport}/oversigt/sektioner")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class VirksomhedOversigtSektionerController extends BaseController
{

    public function init(Request $request)
    {
        parent::init($request);
//    $this->breadcrumbs->addItem('rapportsektion.labels.singular', $this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport)));
    }

    /**
     * Lists all RapportSektion entities.
     *
     * @Route("/", name="virksomhed_oversigt_rapport_sektioner")
     * @Method("GET")
     * @Template("AppBundle:RapportSektion\VirksomhedOverview:index.html.twig")
     */
    public function indexAction(VirksomhedRapport $virksomhed_rapport)
    {
        $entities = $virksomhed_rapport->getRapportOversigtSektioner();
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new RapportSektion entity.
     *
     * @Route("/", name="virksomhed_oversigt_rapport_sektioner_create")
     * @Method("POST")
     * @Template("AppBundle:RapportSektion:new.html.twig")
     */
    public function createAction(Request $request, VirksomhedRapport $virksomhed_rapport)
    {
        $entity = new RapportSektion();
        $entity->setVirksomhedOversigtRapport($virksomhed_rapport);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $entity->getVirksomhedOversigtRapport()->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RapportSektion entity.
     *
     * @param RapportSektion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RapportSektion $entity)
    {

        $form = $this->createForm(new RapportSektionType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_oversigt_rapport_sektioner_create', array('virksomhed_rapport' => $entity->getVirksomhedOversigtRapport()->getId())),
            'method' => 'POST',
        ));

        $this->addCreate($form, $this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $entity->getVirksomhedOversigtRapport()->getId())));

        return $form;
    }

    /**
     * Displays a form to create a new RapportSektion entity.
     *
     * @Route("/new", name="virksomhed_oversigt_rapport_sektioner_new")
     * @Method("GET")
     * @Template("AppBundle:RapportSektion:new.html.twig")
     */
    public function newAction(VirksomhedRapport $virksomhed_rapport)
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId())));

        $entity = new RapportSektion();
        $entity->setVirksomhedOversigtRapport($virksomhed_rapport);
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing RapportSektion entity.
     *
     * @Route("/{id}/edit", name="virksomhed_oversigt_rapport_sektioner_edit")
     * @Method("GET")
     * @Template("AppBundle:RapportSektion:edit.html.twig")
     */
    public function editAction(VirksomhedRapport $virksomhed_rapport, RapportSektion $entity)
    {

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RapportSektion entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($virksomhed_rapport, $entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a RapportSektion entity.
     *
     * @param RapportSektion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(RapportSektion $entity)
    {

        $form = $this->createForm(new RapportSektionType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_oversigt_rapport_sektioner_update', array('virksomhed_rapport' => $entity->getVirksomhedOversigtRapport()->getId(), 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $entity->getVirksomhedOversigtRapport()->getId())));
        $this->addUpdateAndExit($form, $this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $entity->getVirksomhedOversigtRapport()->getId())));

        return $form;
    }

    /**
     * Edits an existing RapportSektion entity.
     *
     * @Route("/{id}/edit", name="virksomhed_oversigt_rapport_sektioner_update")
     * @Method("PUT")
     * @Template("AppBundle:RapportSektion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var RapportSektion $entity */
        $entity = $em->getRepository('AppBundle:RapportSektioner\RapportSektion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RapportSektion entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getVirksomhedOversigtRapport(), $id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->flash->success('rapport_sections.confirmation.updated');

            $destination = $request->getRequestUri();
            if ($button_destination = $this->getButtonDestination($editForm)) {
                $destination = $button_destination;
            }
            return $this->redirect($destination);
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a RapportSektion entity.
     *
     * @Route("/{id}", name="virksomhed_oversigt_rapport_sektioner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VirksomhedRapport $virksomhed_rapport, $id)
    {
        $form = $this->createDeleteForm($virksomhed_rapport, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RapportSektioner\RapportSektion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RapportSektion entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('virksomhed_oversigt_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId())));
    }

    /**
     * Creates a form to delete a RapportSektion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VirksomhedRapport $virksomhed_rapport, $id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('virksomhed_oversigt_rapport_sektioner_delete', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'pinned',
                ),
            ))
            ->getForm();
    }

    private function rapportCheck(VirksomhedRapport $virksomhed_rapport) {
        $sections = $virksomhed_rapport->getRapportOversigtSektioner();
        self::RAPPORT_SEKTIONER;
    }
}
