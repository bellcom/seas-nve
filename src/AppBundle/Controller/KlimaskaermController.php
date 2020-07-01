<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\KlimaskaermRepository;
use AppBundle\Entity\Klimaskaerm;
use AppBundle\Form\Type\KlimaskaermImportType;
use AppBundle\Form\Type\KlimaskaermType;
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
 * Klimaskaerm controller.
 *
 * @Route("/klimaskaerm")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class KlimaskaermController extends BaseController
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
        $this->breadcrumbs->addItem('klimaskaerm.labels.singular', $this->generateUrl('klimaskaerm'));
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->translator = $this->container->get('translator');
    }


    /**
     * Lists all Klimaskaerm entities.
     *
     * @Route("/", name="klimaskaerm")
     * @Method("GET")
     * @Template("AppBundle:Klimaskaerm:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // We need more time!
        set_time_limit(0);
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Klimaskaerm')->findAll();

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
            $this->flash->success('klimaskaerm.confirmation.created');

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

        $this->addCreate($form, $this->generateUrl('klimaskaerm'));

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
     * Displays a form to import file with Klimaskaerm entities data.
     *
     * @Route("/import", name="klimaskaerm_import_form")
     * @Method("GET")
     * @Template("AppBundle:Klimaskaerm:import.html.twig")
     */
    public function importFormAction()
    {
        $this->breadcrumbs->addItem('common.import', $this->generateUrl('klimaskaerm'));
        $form = $this->createImportForm();

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Imports a new Klimaskaerm entities.
     *
     * @Route("/import", name="klimaskaerm_import")
     * @Method("POST")
     * @Template("AppBundle:Klimaskaerm:import.html.twig")
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
                $this->flash->error('klimaskaerm.error.import_file');
            }
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var KlimaskaermRepository $repository */
            $repository = $em->getRepository(Klimaskaerm::class);
            $columns = $em->getClassMetadata(Klimaskaerm::class)->getColumnNames();
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
                $entity = new Klimaskaerm();
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
            $this->flash->success($this->translator->trans('klimaskaerm.confirmation.imported', array(
                '%created' => $created,
                '%updated' => $updated,
            )));

            return $this->redirect($this->generateUrl('klimaskaerm'));
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Klimaskaerm entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportForm()
    {
        $form = $this->createForm(new KlimaskaermImportType(), null, array(
            'action' => $this->generateUrl('klimaskaerm_import'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('klimaskaerm'));

        return $form;
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

        $this->addUpdate($form, $this->generateUrl('klimaskaerm'));
        $this->addUpdateAndExit($form, $this->generateUrl('klimaskaerm'));

        return $form;
    }
    /**
     * Edits an existing Klimaskaerm entity.
     *
     * @Route("/{id}/edit", name="klimaskaerm_update")
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

            $this->flash->success('klimaskaerm.confirmation.updated');

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
            $this->flash->success('klimaskaerm.confirmation.deleted');
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
                    'class' => 'pinned',
                ),
            ))
            ->getForm()
        ;
    }

    private function export(array $result, $format) {
        $filename = 'klimaskaerme--' . date('d-m-Y_Hi') . '.' . $format;
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
        $columns = $em->getClassMetadata(Klimaskaerm::class)->getColumnNames();
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
