<?php

namespace AppBundle\Controller\BelysningTiltagDetail;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\BelysningTiltagDetail\NytArmatur;
use AppBundle\Entity\BelysningTiltagDetail\NytArmaturRepository;
use AppBundle\Form\BelysningTiltagDetail\NytArmaturImportType;
use AppBundle\Form\BelysningTiltagDetail\NytArmaturType;
use Doctrine\ORM\EntityManager;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * BelysningTiltagDetail\NytArmatur controller.
 *
 * @Route("/belysningtiltagdetail_nytarmatur")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class NytArmaturController extends BaseController
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('nytArmatur.labels.singular', $this->generateUrl('belysningtiltagdetail_nytarmatur'));
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->translator = $this->container->get('translator');
    }

    /**
     * Lists all BelysningTiltagDetail\NytArmatur entities.
     *
     * @Route("/", name="belysningtiltagdetail_nytarmatur")
     * @Method("GET")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // We need more time!
        set_time_limit(0);
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->findAll();

        $_format = '';
        if ($request->query->has('_format')) {
            $value = $request->query->get('_format');
            if ($value == 'xlsx' || $value == 'csv') {
                $_format = $value;
            }
        }

        if (!empty($_format)) {
            return $this->export($entities, $_format);
        }

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/", name="belysningtiltagdetail_nytarmatur_create")
     * @Method("POST")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NytArmatur();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->flash->success('nytArmatur.confirmation.created');

            return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BelysningTiltagDetail\NytArmatur entity.
     *
     * @param NytArmatur $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NytArmatur $entity)
    {
        $form = $this->createForm(new NytArmaturType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_nytarmatur_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_nytarmatur'));

        return $form;
    }

    /**
     * Displays a form to create a new BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/new", name="belysningtiltagdetail_nytarmatur_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('belysningtiltagdetail_nytarmatur'));

        $entity = new NytArmatur();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to import file with NytArmatur entities data.
     *
     * @Route("/import", name="belysningtiltagdetail_nytarmatur_import_form")
     * @Method("GET")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:import.html.twig")
     */
    public function importFormAction()
    {
        $this->breadcrumbs->addItem('common.import', $this->generateUrl('belysningtiltagdetail_nytarmatur'));
        $form = $this->createImportForm();

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Imports a new NytArmatur entities.
     *
     * @Route("/import", name="belysningtiltagdetail_nytarmatur_import")
     * @Method("POST")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:import.html.twig")
     */
    public function importAction(Request $request)
    {
        $form = $this->createImportForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $updated = 0;
            $created = 0;

            // Get file
            $file = $form->get('filepath');
            $fileData = $file->getData();
            $reader = Reader::createFromPath($fileData->getPathname());
            try {
                $results = $reader->fetchAssoc();
            }
            catch (\Exception $e) {
                $results = array();
                $this->flash->error('nytArmatur.error.import_file');
            }
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var NytArmaturRepository $repository */
            $repository = $em->getRepository(NytArmatur::class);
            $columns = $em->getClassMetadata(NytArmatur::class)->getColumnNames();
            // Remove 'id' column from properties.
            $columns = array_filter($columns, function($val) { return $val != 'id'; });
            foreach ($results as $row) {
                if (!empty($row['id']) && $entity = $repository->find($row['id'])) {
                    // Update  entity.
                    foreach ($columns as $column) {
                        if (isset($row[$column])) {
                            $value = $row[$column];
                            if ($this->accessor->getValue($entity, $column) != $value) {
                                $this->accessor->setValue($entity, $column, $value);
                            }
                        }
                    }
                    // Save entity only if it has changes.
                    $uow = $em->getUnitOfWork();
                    $uow->computeChangeSets();
                    if ($uow->getEntityChangeSet($entity)) {
                        $em->persist($entity);
                        $updated++;
                    }
                    continue;
                }

                // Insert entity.
                $entity = new NytArmatur();
                foreach ($columns as $column) {
                    $value = '';
                    if (isset($row[$column])) {
                        $value = $row[$column];
                    }
                    $this->accessor->setValue($entity, $column, $value);
                }
                $em->persist($entity);
                $created++;
            }
            $em->flush();
            $this->flash->success($this->translator->trans('nytArmatur.confirmation.imported', array(
                '%created' => $created,
                '%updated' => $updated,
            )));

            return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BelysningTiltagDetail\NytArmatur entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportForm()
    {
        $form = $this->createForm(new NytArmaturImportType(), null, array(
            'action' => $this->generateUrl('belysningtiltagdetail_nytarmatur_import'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_nytarmatur'));

        return $form;
    }

    /**
     * Finds and displays a BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_nytarmatur_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}/edit", name="belysningtiltagdetail_nytarmatur_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(NytArmatur $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
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
    * Creates a form to edit a BelysningTiltagDetail\NytArmatur entity.
    *
    * @param NytArmatur $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NytArmatur $entity)
    {
        $form = $this->createForm(new NytArmaturType(), $entity, array(
            'action' => $this->generateUrl('belysningtiltagdetail_nytarmatur_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('belysningtiltagdetail_nytarmatur_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_nytarmatur_update")
     * @Method("PUT")
     * @Template("AppBundle:BelysningTiltagDetail\NytArmatur:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->flash->success('nytArmatur.confirmation.updated');

            return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BelysningTiltagDetail\NytArmatur entity.
     *
     * @Route("/{id}", name="belysningtiltagdetail_nytarmatur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BelysningTiltagDetail\NytArmatur entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->flash->success('nytArmatur.confirmation.deleted');
        }

        return $this->redirect($this->generateUrl('belysningtiltagdetail_nytarmatur'));
    }

    /**
     * Creates a form to delete a BelysningTiltagDetail\NytArmatur entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:BelysningTiltagDetail\NytArmatur');
        $nytarmatur = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($nytarmatur);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('belysningtiltagdetail_nytarmatur_delete', array('id' => $id)))
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

    private function export(array $result, $format) {
        $filename = 'armaturer-' . date('d-m-Y_Hi') . '.' . $format;
        switch ($format) {
            case 'csv':
                $contentType = 'text/csv';
                break;
            case 'xlsx':
                $contentType = 'application/vnd.ms-excel';
                break;
        }

        $response = new StreamedResponse();
        $response->headers->add([
            'Content-type' => $contentType,
            'Content-disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-control' => 'max-age=0',
        ]);
        $em = $this->getDoctrine()->getManager();
        $columns = $em->getClassMetadata(NytArmatur::class)->getColumnNames();
        $streamer = $this->container->get('aaplus.exporter.csv_stream');
        $streamer->setConfig([
            'columns' => $columns,
        ]);
        $filepath = $this->container->getParameter('data_export_path'). '/' . $filename;
        $response->setCallback(function () use ($result, $streamer, $format, $filepath) {
            $streamer->start($filepath, $format);
            $streamer->header();
            foreach ($result as $item) {
                $streamer->item($item);
            }
            $streamer->end();
            print(file_get_contents($filepath));
        });

        return $response;
    }

}
