<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SolcelleRepository;
use AppBundle\Form\Type\SolcelleImportType;
use AppBundle\Entity\Solcelle;
use AppBundle\Form\Type\SolcelleType;
use AppBundle\Controller\BaseController;
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
 * Solcelle controller.
 *
 * @Route("/solcelle")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class SolcelleController extends BaseController
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function init(Request $request)
    {
        parent::init($request);
        $this->breadcrumbs->addItem('solcelle.labels.singular', $this->generateUrl('solcelle'));
        $this->accessor = PropertyAccess::createPropertyAccessor();
        $this->translator = $this->container->get('translator');
    }


    /**
     * Lists all Solcelle entities.
     *
     * @Route("/", name="solcelle")
     * @Method("GET")
     * @Template("AppBundle:Solcelle:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        // We need more time!
        set_time_limit(0);
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Solcelle')->findAll();

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
     * Creates a new Solcelle entity.
     *
     * @Route("/", name="solcelle_create")
     * @Method("POST")
     * @Template("AppBundle:Solcelle:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Solcelle();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->flash->success('solcelle.confirmation.created');

            return $this->redirect($this->generateUrl('solcelle'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Solcelle entity.
     *
     * @param Solcelle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Solcelle $entity)
    {
        $form = $this->createForm(new SolcelleType(), $entity, array(
            'action' => $this->generateUrl('solcelle_create'),
            'method' => 'POST',
        ));

        $this->addCreate($form, $this->generateUrl('solcelle'));

        return $form;
    }

    /**
     * Displays a form to create a new Solcelle entity.
     *
     * @Route("/new", name="solcelle_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $this->breadcrumbs->addItem('common.add', $this->generateUrl('solcelle'));

        $entity = new Solcelle();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to import file with Solcelle entities data.
     *
     * @Route("/import", name="solcelle_import_form")
     * @Method("GET")
     * @Template("AppBundle:Solcelle:import.html.twig")
     */
    public function importFormAction()
    {
        $this->breadcrumbs->addItem('common.import', $this->generateUrl('solcelle'));
        $form = $this->createImportForm();

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Imports a new Solcelle entities.
     *
     * @Route("/import", name="solcelle_import")
     * @Method("POST")
     * @Template("AppBundle:Solcelle:import.html.twig")
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
                $this->flash->error('solcelle.error.import_file');
            }
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            /** @var SolcelleRepository $repository */
            $repository = $em->getRepository(Solcelle::class);
            $columns = $em->getClassMetadata(Solcelle::class)->getColumnNames();
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
                $entity = new Solcelle();
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
            $this->flash->success($this->translator->trans('solcelle.confirmation.imported', array(
                '%created' => $created,
                '%updated' => $updated,
            )));

            return $this->redirect($this->generateUrl('solcelle'));
        }

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Solcelle entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createImportForm()
    {
        $form = $this->createForm(new SolcelleImportType(), null, array(
            'action' => $this->generateUrl('solcelle_import'),
            'method' => 'POST',
        ));

        $this->addUpdate($form, $this->generateUrl('solcelle'));

        return $form;
    }

    /**
     * Finds and displays a Solcelle entity.
     *
     * @Route("/{id}", name="solcelle_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Solcelle')->find($id);
        $this->breadcrumbs->addItem($entity, $this->generateUrl('solcelle_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solcelle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Solcelle entity.
     *
     * @Route("/{id}/edit", name="solcelle_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Solcelle $entity)
    {
        $this->breadcrumbs->addItem($entity, $this->generateUrl('solcelle_show', array('id' => $entity->getId())));
        $this->breadcrumbs->addItem('common.edit', $this->generateUrl('solcelle_show', array('id' => $entity->getId())));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solcelle entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Solcelle entity.
     *
     * @param Solcelle $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Solcelle $entity)
    {
        $form = $this->createForm(new SolcelleType(), $entity, array(
            'action' => $this->generateUrl('solcelle_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('solcelle'));
        $this->addUpdateAndExit($form, $this->generateUrl('solcelle'));

        return $form;
    }

    /**
     * Edits an existing Solcelle entity.
     *
     * @Route("/{id}/edit", name="solcelle_update")
     * @Method("PUT")
     * @Template("AppBundle:Solcelle:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Solcelle')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Solcelle entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            $this->flash->success('solcelle.confirmation.updated');

          $destination = $request->getRequestUri();
          if ($button_destination = $this->getButtonDestination($editForm->getClickedButton())) {
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
     * Deletes a Solcelle entity.
     *
     * @Route("/{id}", name="solcelle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Solcelle')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Solcelle entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->flash->success('solcelle.confirmation.deleted');
        }

        return $this->redirect($this->generateUrl('solcelle'));
    }

    /**
     * Creates a form to delete a Solcelle entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Solcelle');
        $solcelle = $repository->find($id);
        $message = $repository->getRemoveErrorMessage($solcelle);

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('solcelle_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'Delete',
                'disabled' => $message,
                'attr' => array(
                    'disabled_message' => $message,
                    'class' => 'pinned',
                ),
            ))
            ->getForm();
    }

    private function export(array $result, $format) {
        $filename = 'solceller--' . date('d-m-Y_Hi') . '.' . $format;
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
        $columns = $em->getClassMetadata(Solcelle::class)->getColumnNames();
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
