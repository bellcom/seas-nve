<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Pumpe;

/**
 * Pumpe controller.
 *
 * @Route("/pumpe")
 */
class PumpeController extends Controller
{

    /**
     * Lists all Pumpe entities.
     *
     * @Route("/", name="pumpe")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Pumpe')->findAll();

        return array(
            'entities' => $entities,
        );
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

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pumpe entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
