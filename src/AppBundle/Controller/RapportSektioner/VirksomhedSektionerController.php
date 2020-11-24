<?php

namespace AppBundle\Controller\RapportSektioner;

use AppBundle\Entity\RapportSektioner\RapportSektionRepository;
use AppBundle\Entity\RapportSektioner\TiltagRapportSektion;
use AppBundle\Entity\ReportText;
use AppBundle\Entity\Tiltag;
use AppBundle\Entity\Virksomhed;
use AppBundle\Entity\RapportSektioner\RapportSektion;
use AppBundle\Entity\VirksomhedRapport;
use AppBundle\Entity\VirksomhedRapportRepository;
use AppBundle\Form\Type\RapportSektion\RapportSektionType;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Exception\UploadableInvalidMimeTypeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Controller\BaseController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * VirksomhedSektionerController controller.
 *
 * @Route("/virksomhed/rapport/{virksomhed_rapport}/{rapport_type}/sektioner")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class VirksomhedSektionerController extends BaseController
{

    /**
     * @var Request
     */
    protected $request;

    public function init(Request $request)
    {
        $this->request = $request;
        parent::init($request);
        $this->breadcrumbs->addItem('virksomhed_rapporter.labels.plural', $this->generateUrl('virksomhed_rapport'));
    }

    /**
     * Lists all RapportSektion entities.
     *
     * @Route("/", name="virksomhed_rapport_sektioner")
     * @Method("GET")
     * @Template("AppBundle:RapportSektion\Virksomhed:index.html.twig")
     */
    public function indexAction(VirksomhedRapport $virksomhed_rapport, $rapport_type)
    {
        $this->breadcrumbs->addItem($virksomhed_rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $virksomhed_rapport->getId())));
        $this->breadcrumbs->addItem('virksomhed_rapporter.rapport_type.' . $rapport_type, $this->generateUrl('virksomhed_rapport_pdf_review', array('id' => $virksomhed_rapport->getId(), 'type' => $rapport_type)));
        $this->breadcrumbs->addItem('Sektioner', $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type)));

        /** @var VirksomhedRapportRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:VirksomhedRapport');
        try {
            $entities = $repository->getRapportSektionerSorted($virksomhed_rapport, $rapport_type);
        }
        catch (\Exception $e) {
            return $this->flash->error($e->getMessage());
        }
        return array(
            'entities' => $entities,
            'rapport' => $virksomhed_rapport,
            'rapport_type' => $rapport_type,
        );
    }

    /**
     * Creates a new RapportSektion entity.
     *
     * @Route("/new/{type}", name="virksomhed_rapport_sektioner_create")
     * @Method("POST")
     * @Template("AppBundle:RapportSektion:new.html.twig")
     */
    public function createAction(Request $request, VirksomhedRapport $virksomhed_rapport, $rapport_type, $type = 'standard')
    {
        $this->breadcrumbs->addItem($virksomhed_rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $virksomhed_rapport->getId())));
        $this->breadcrumbs->addItem('virksomhed_rapporter.rapport_type.' . $rapport_type, $this->generateUrl('virksomhed_rapport_pdf_review', array('id' => $virksomhed_rapport->getId(), 'type' => $rapport_type)));
        $this->breadcrumbs->addItem('Sektioner', $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type)));

        /** @var RapportSektionRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:RapportSektioner\RapportSektion');
        $entity = $repository->create($type, array('rapport_type' => $rapport_type));
        if (empty($entity) || !$entity->isAllowed(RapportSektion::ACTION_ADD)) {
            throw $this->createNotFoundException('Rapport section not found');
        }
        $entity->setVirksomhedRapport($virksomhed_rapport, $rapport_type);
        $form = $this->createCreateForm($entity, $rapport_type, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            try {
                $this->handleUploads($entity, $form);
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $this->flash->success('rapportsektion.confirmation.created');

                $destination = $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $entity->getRapport()->getId(), 'rapport_type' => $rapport_type));
                if ($this->request->get('destination')) {
                    $destination = $this->request->get('destination');
                }

                return $this->redirect($destination);
            }
            catch (UploadableInvalidMimeTypeException $e) {
                $this->flash->error('rapport_sections.error.filetype');
            }
            catch (\Exception $e) {
                $this->flash->error('rapport_sections.error.general');
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'form_tpl' => $this->getFormTpl($entity),
        );
    }

    /**
     * Creates a form to create a RapportSektion entity.
     *
     * @param RapportSektion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RapportSektion $entity, $rapport_type, $type)
    {
        $params = array('virksomhed_rapport' => $entity->getRapport()->getId(), 'rapport_type' => $rapport_type, 'type' => $type);
        // Getting desired destination for form redirect.
        $destination = $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $entity->getRapport()->getId(), 'rapport_type' => $rapport_type));
        if ($this->request->get('destination')) {
            $destination = $this->request->get('destination');
            $params['destination'] = $destination;
        }

        $formType = $entity->getFormType();
        $form = $this->createForm(new $formType, $entity, array(
            'action' => $this->generateUrl('virksomhed_rapport_sektioner_create', $params),
            'method' => 'POST',
            'entity_manager' => $this->get('doctrine.orm.entity_manager'),
        ));

        $this->addCreate($form, $destination);

        return $form;
    }

    /**
     * Displays a form to create a new RapportSektion entity.
     *
     * @Route("/new/{type}", name="virksomhed_rapport_sektioner_new")
     * @Method("GET")
     * @Template("AppBundle:RapportSektion:new.html.twig")
     */
    public function newAction(VirksomhedRapport $virksomhed_rapport, $rapport_type, $type = 'standard')
    {
        $this->breadcrumbs->addItem($virksomhed_rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $virksomhed_rapport->getId())));
        $this->breadcrumbs->addItem('virksomhed_rapporter.rapport_type.' . $rapport_type, $this->generateUrl('virksomhed_rapport_pdf_review', array('id' => $virksomhed_rapport->getId(), 'type' => $rapport_type)));
        $this->breadcrumbs->addItem('Sektioner', $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type)));

        /** @var RapportSektionRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:RapportSektioner\RapportSektion');
        $entity = $repository->create($type, array('rapport_type' => $rapport_type));
        if (empty($entity) || !$entity->isAllowed(RapportSektion::ACTION_ADD)) {
            throw $this->createNotFoundException('Rapport section not found');
        }
        $entity->setVirksomhedRapport($virksomhed_rapport, $rapport_type);
        $form = $this->createCreateForm($entity, $rapport_type, $type);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'default_value_groups' => $this->getDefaultValueGroups($entity),
            'form_tpl' => $this->getFormTpl($entity),
        );
    }

    /**
     * Displays a form to edit an existing RapportSektion entity.
     *
     * @Route("/{id}/edit", name="virksomhed_rapport_sektioner_edit")
     * @Method("GET")
     * @Template("AppBundle:RapportSektion:edit.html.twig")
     */
    public function editAction(VirksomhedRapport $virksomhed_rapport, $rapport_type, RapportSektion $entity)
    {
        $this->breadcrumbs->addItem($virksomhed_rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $virksomhed_rapport->getId())));
        $this->breadcrumbs->addItem('virksomhed_rapporter.rapport_type.' . $rapport_type, $this->generateUrl('virksomhed_rapport_pdf_review', array('id' => $virksomhed_rapport->getId(), 'type' => $rapport_type)));
        $this->breadcrumbs->addItem('Sektioner', $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type)));
        $this->breadcrumbs->addItem($entity->getTitle() ?: 'common.edit', $this->generateUrl('virksomhed_rapport_sektioner_edit', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type, 'id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RapportSektion entity.');
        }

        $editForm = $this->createEditForm($entity, $rapport_type);
        $deleteForm = $this->createDeleteForm($virksomhed_rapport, $rapport_type, $entity->getId());

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $entity->isAllowed(RapportSektion::ACTION_DELETE) ? $deleteForm->createView() : NULL,
            'default_value_groups' => $this->getDefaultValueGroups($entity),
            'form_tpl' => $this->getFormTpl($entity),
        );
    }

    /**
     * Creates a form to edit a RapportSektion entity.
     *
     * @param RapportSektion $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(RapportSektion $entity, $rapport_type)
    {
        $params = array('virksomhed_rapport' => $entity->getRapport()->getId(), 'rapport_type' => $rapport_type, 'id' => $entity->getId(), 'type' => $entity->getType());
        // Getting desired destination for form redirect.
        $destination = $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $entity->getRapport($rapport_type)->getId(), 'rapport_type' => $rapport_type));
        if ($this->request->get('destination')) {
            $destination = $this->request->get('destination');
            $params['destination'] = $destination;
        }

        $formType = $entity->getFormType();
        $form = $this->createForm($formType, $entity, array(
            'action' => $this->generateUrl('virksomhed_rapport_sektioner_update', $params),
            'method' => 'PUT',
            'entity_manager' => $this->get('doctrine.orm.entity_manager'),
        ));

        $this->addUpdate($form, $destination);
        $this->addUpdateAndExit($form, $destination);

        return $form;
    }

    /**
     * Edits an existing RapportSektion entity.
     *
     * @Route("/{id}/edit", name="virksomhed_rapport_sektioner_update")
     * @Method("PUT")
     * @Template("AppBundle:RapportSektion:edit.html.twig")
     */
    public function updateAction(Request $request, $rapport_type, $id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var RapportSektion $entity */
        $entity = $em->getRepository('AppBundle:RapportSektioner\RapportSektion')->find($id);
        $virksomhed_rapport = $entity->getRapport();
        $this->breadcrumbs->addItem($virksomhed_rapport, $this->generateUrl('virksomhed_rapport_show', array('id' => $virksomhed_rapport->getId())));
        $this->breadcrumbs->addItem('virksomhed_rapporter.rapport_type.' . $rapport_type, $this->generateUrl('virksomhed_rapport_pdf_review', array('id' => $virksomhed_rapport->getId(), 'type' => $rapport_type)));
        $this->breadcrumbs->addItem('Sektioner', $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type)));
        $this->breadcrumbs->addItem($entity->getTitle() ?: 'common.edit', $this->generateUrl('virksomhed_rapport_sektioner_edit', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type, 'id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find RapportSektion entity.');
        }

        $deleteForm = $this->createDeleteForm($entity->getRapport(), $rapport_type, $id);
        $editForm = $this->createEditForm($entity, $rapport_type);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            try {
                $this->handleUploads($entity, $editForm);
                $em->flush();
                $this->flash->success('rapportsektion.confirmation.updated');

                $destination = $request->getRequestUri();
                if ($button_destination = $this->getButtonDestination($editForm)) {
                    $destination = $button_destination;
                }
                return $this->redirect($destination);

            }
            catch (UploadableInvalidMimeTypeException $e) {
                $this->flash->error('rapportsektion.error.filetype');
            }
            catch (\Exception $e) {
                $this->flash->error('rapportsektion.error.general');
            }
        }

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $entity->isAllowed(RapportSektion::ACTION_DELETE) ? $deleteForm->createView() : NULL,
            'form_tpl' => $this->getFormTpl($entity),
        );
    }

    /**
     * Deletes a RapportSektion entity.
     *
     * @Route("/{id}", name="virksomhed_rapport_sektioner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, VirksomhedRapport $virksomhed_rapport, $rapport_type, $id)
    {
        $form = $this->createDeleteForm($virksomhed_rapport, $rapport_type, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:RapportSektioner\RapportSektion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find RapportSektion entity.');
            }

            if (!$entity->isAllowed(RapportSektion::ACTION_ADD)) {
                throw $this->createAccessDeniedException('Action is not allowed');
            }

            $em->remove($entity);
            $em->flush();
        }

        $destination = $this->generateUrl('virksomhed_rapport_sektioner', array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type));
        if ($this->request->get('destination')) {
            $destination = $this->request->get('destination');
        }
        return $this->redirect($destination);
    }

    /**
     * Creates a form to delete a RapportSektion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VirksomhedRapport $virksomhed_rapport, $rapport_type, $id)
    {
        $params = array('virksomhed_rapport' => $virksomhed_rapport->getId(), 'rapport_type' => $rapport_type, 'id' => $id);
        if ($this->request->get('destination')) {
            $destination = $this->request->get('destination');
            $params['destination'] = $destination;
        }

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('virksomhed_rapport_sektioner_delete', $params))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'attr' => array(
                    'class' => 'pinned',
                ),
            ))
            ->getForm();
    }

    /**
     * Handles the upload of the file.
     *
     * @param \AppBundle\Entity\RapportSektioner\RapportSektion $entity
     *   Rapport sektion entity.
     * @param Form $form
     *   Form object.
     */
    protected function handleUploads(RapportSektion $entity, Form $form) {
        if (!property_exists($entity, 'filepath')) {
            return;
        }
        if ($form->has('imagestandard')) {
            if ($filepathCustom = $form->get('filepath')->getData()) {
                $entity->setFilepath($filepathCustom);

                $fileInfo = $entity->getFilepath();
                if (is_object($fileInfo) && $fileInfo instanceof UploadedFile) {
                    $manager = $this->get('stof_doctrine_extensions.uploadable.manager');
                    $manager->markEntityToUpload($entity, $fileInfo);
                }
            }
            elseif ($imageStandard = $form->get('imagestandard')->getData()) {
                $entity->setFilepathString($imageStandard->getFilepath());
            }
        }
    }

    /**
     * Gets the default value groups that entity supports.
     *
     * Is it generated my mapping entity text fields (defaultable) and the possible options.
     *
     * @param RapportSektion $entity
     *   Report section entity.
     *
     * @return array
     *   Default value groups array.
     */
    protected function getDefaultValueGroups(RapportSektion $entity) {
        $default_value_groups = array();

        $defaultValueTexts = $entity->getDefaultableTextFields();
        foreach ($defaultValueTexts as $textFieldName) {

            // Handling dynamic default text for Tiltag section.
            $textKey = $textFieldName;
            if ($entity instanceof TiltagRapportSektion) {
                if (strpos($textFieldName, $entity->getTiltagType()) === FALSE) {
                    continue;
                }
                $textKey = 'text';
            }

            $em = $this->getDoctrine()->getManager();
            $reportTexts = $em->getRepository('AppBundle:ReportText')->findBy(array('type' => $entity->getType() . '_' . $textFieldName));

            /** @var ReportText $reportText */
            foreach ($reportTexts as $reportText) {
                $default_value_groups[$textKey][$reportText->getId()] = array(
                    'title' => $reportText->getTitle() . ($reportText->isStandard() ? ' (standard)' : ''),
                    'body' => $reportText->getBody()
                );
            }
        }

        return $default_value_groups;
    }

    private function getFormTpl($entity) {
        $tpl_path = "AppBundle:RapportSektion:forms/";
        $tpl = $tpl_path . 'standard.html.twig';
        if ($this->get('templating')->exists($tpl_path . $entity->getType() . '.html.twig')) {
            $tpl = $tpl_path . $entity->getType() . '.html.twig';
        }
        return $tpl;
    }

}
