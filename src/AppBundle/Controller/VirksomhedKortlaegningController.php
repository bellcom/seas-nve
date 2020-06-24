<?php

namespace AppBundle\Controller;

use AppBundle\DBAL\Types\SlutanvendelseType;
use AppBundle\Entity\Virksomhed;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\VirksomhedKortlaegning;
use AppBundle\Form\Type\VirksomhedKortlaegningType;
use AppBundle\Controller\BaseController;

/**
 * VirksomhedKortlaegning controller.
 *
 * @Route("/virksomhed/{id}/kortlaegning")
 * @Security("has_role('ROLE_SUPER_ADMIN')")
 */
class VirksomhedKortlaegningController extends BaseController
{

    public function init(Request $request) {
        parent::init($request);
        $this->breadcrumbs->addItem('virksomhed.labels.plural', $this->generateUrl('virksomhed'));
    }

    /**
     * Lists all VirksomhedKortlaegning entities.
     *
     * @Route("/", name="virksomhed_kortlaegning")
     * @Method("GET")
     * @Template("AppBundle:VirksomhedKortlaegning:form.html.twig")
     */
    public function indexAction(Request $request, Virksomhed $virksomhed)
    {
        $this->breadcrumbs->addItem($virksomhed, $this->generateUrl('virksomhed_show', array('id' => $virksomhed->getId())));
        $this->breadcrumbs->addItem('virksomhed_kortlaegning.label.singular' );
        $kortlaegning = $virksomhed->getKortlaegning();
        if (empty($kortlaegning)) {
            $kortlaegning = new VirksomhedKortlaegning();
            $kortlaegning->setVirksomhed($virksomhed);
        }
        $form = $this->createEditForm($kortlaegning);
        return array(
            'entity' => $kortlaegning,
            'form' => $form->createView(),
            'slutanvendelser_label' => SlutanvendelseType::getChoices(),
        );
    }

    /**
     * Edits an existing VirksomhedKortlaegning entity.
     *
     * @Route("/", name="virksomhed_kortlaegning_update")
     * @Method("PUT")
     * @Template("AppBundle:VirksomhedKortlaegning:form.html.twig")
     */
    public function updateAction(Request $request, Virksomhed $virksomhed)
    {
        $kortlaegning = $virksomhed->getKortlaegning();
        if (empty($kortlaegning)) {
            $kortlaegning = new VirksomhedKortlaegning();
            $kortlaegning->setVirksomhed($virksomhed);
        }


        $form = $this->createEditForm($kortlaegning);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (!$virksomhed->getKortlaegning()) {
                $virksomhed->setKortlaegning($kortlaegning);
                $em->persist($virksomhed);
            }
            $em->flush();

            $this->flash->success('virksomhed_kortlaegning.confirmation.updated');

            $destination = $request->getRequestUri();
            if ($button_destination = $this->getButtonDestination($form->getClickedButton())) {
                $destination = $button_destination;
            }
            return $this->redirect($destination);
        }

        return array(
            'entity' => $kortlaegning,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to edit a VirksomhedKortlaegning entity.
     *
     * @param VirksomhedKortlaegning $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(VirksomhedKortlaegning $entity)
    {
        $form = $this->createForm(new VirksomhedKortlaegningType(), $entity, array(
            'action' => $this->generateUrl('virksomhed_kortlaegning_update', array('id' => $entity->getVirksomhed()->getId())),
            'method' => 'PUT',
        ));

        $this->addUpdate($form, $this->generateUrl('virksomhed_show', array('id' => $entity->getVirksomhed()->getId())));
        $this->addUpdateAndExit($form, $this->generateUrl('virksomhed_show', array('id' => $entity->getVirksomhed()->getId())));

        return $form;
    }

}
