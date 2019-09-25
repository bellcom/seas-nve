<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PumpeRepository;
use AppBundle\Form\Type\PumpeImportType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Pumpe;
use AppBundle\Form\Type\PumpeType;
use AppBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Reader;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Translation\TranslatorInterface;


/**
 * Pumpe controller.
 *
 * @Route("/pumpe")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class PumpeController extends BaseController
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
        $this->breadcrumbs->addItem('pumpe.labels.singular', $this->generateUrl('pumpe'));
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->translator = $this->container->get('translator');
    }

    /**
     * Lists all Pumpe entities.
     *
     * @Route("/", name="pumpe")
     * @Method("GET")
     * @Template("AppBundle:Pumpe:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // We need more time!
        set_time_limit(0);

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Pumpe')->findAll();

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
     * Creates a new Pumpe entity.
     *
     * @Route("/", name="pumpe_create")
     * @Method("POST")
     * @Template("AppBundle:Pumpe:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Pumpe();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->flash->success('pumpe.confirmation.created');

            return $this->redirect($this->generateUrl('pumpe'));

        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pumpe entity.
     *
     * @param Pumpe $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pumpe $entity)
    {
        $form = $this->createForm(new PumpeType(), $entity, array(
            'action' => $this->generateUrl('pumpe_create'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('pumpe'));

        return $form;
    }

    /**
     * Displays a form to create a new Pumpe entity.
     *
     * @Route("/new", name="pumpe_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('pumpe'));

        $entity = new Pumpe();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to import file with Pumpe entities data.
     *
     * @Route("/import", name="pumpe_import_form")
     * @Method("GET")
     * @Template("AppBundle:Pumpe:import.html.twig")
     */
    public function importFormAction()
    {
        $this->breadcrumbs->addItem('common.import', $this->generateUrl('pumpe'));
        $form = $this->createImportForm();

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Imports a new Pumpe entities.
     *
     * @Route("/import", name="pumpe_import")
     * @Method("POST")
     * @Template("AppBundle:Pumpe:import.html.twig")
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
                $this->flash->error('pumpe.error.import_file');
            }
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var PumpeRepository $repository */
            $repository = $em->getRepository(Pumpe::class);
            $columns = $em->getClassMetadata(Pumpe::class)->getColumnNames();
            // Remove 'id' column from properties.
            $columns = array_filter($columns, function($val) { return $val != 'id'; });
            foreach ($results as $row) {
                if (!empty($row['id']) && $entity = $repository->find($row['id'])) {
                    // Update  entity.
                    foreach ($columns as $column) {
                        if (isset($row[$column])) {
                            $value = $repository->getTypedValue($column, $row[$column]);
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
                $entity = new Pumpe();
                foreach ($columns as $column) {
                    $value = '';
                    if (isset($row[$column])) {
                        $value = $row[$column];
                    }
                    $this->accessor->setValue($entity, $column, $repository->getTypedValue($column, $value));
                }
                $em->persist($entity);
                $created++;
            }
            $em->flush();
            $this->flash->success($this->translator->trans('pumpe.confirmation.imported', array(
                '%created' => $created,
                '%updated' => $updated,
            )));

            return $this->redirect($this->generateUrl('pumpe'));
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Pumpe entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportForm()
    {
        $form = $this->createForm(new PumpeImportType(), null, array(
            'action' => $this->generateUrl('pumpe_import'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('pumpe'));

        return $form;
    }

    /**
     * Finds and displays a Pumpe entity.
     *
     * @Route("/{id}", name="pumpe_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pumpe')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('pumpe_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pumpe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Pumpe entity.
     *
     * @Route("/{id}/edit", name="pumpe_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Pumpe $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('pumpe_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('pumpe_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pumpe entity.');
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
    * Creates a form to edit a Pumpe entity.
    *
    * @param Pumpe $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pumpe $entity)
    {
        $form = $this->createForm(new PumpeType(), $entity, array(
            'action' => $this->generateUrl('pumpe_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('pumpe_show', array('id' => $entity->getId())));

        return $form;
    }
    /**
     * Edits an existing Pumpe entity.
     *
     * @Route("/{id}", name="pumpe_update")
     * @Method("PUT")
     * @Template("AppBundle:Pumpe:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Pumpe')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pumpe entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->flash->success('pumpe.confirmation.updated');

            return $this->redirect($this->generateUrl('pumpe'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Pumpe entity.
     *
     * @Route("/{id}", name="pumpe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Pumpe')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pumpe entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->flash->success('pumpe.confirmation.deleted');
        }

        return $this->redirect($this->generateUrl('pumpe'));
    }

    /**
     * Creates a form to delete a Pumpe entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Pumpe');
        $pumpe = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($pumpe);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pumpe_delete', array('id' => $id)))
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
        $filename = 'pumper--' . date('d-m-Y_Hi') . '.' . $format;
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
        $columns = $em->getClassMetadata(Pumpe::class)->getColumnNames();
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
