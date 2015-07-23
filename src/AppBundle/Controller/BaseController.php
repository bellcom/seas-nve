<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Yavin\Symfony\Controller\InitControllerInterface;

/**
 * Base controller.
 */
abstract class BaseController extends Controller implements InitControllerInterface {
  protected $breadcrumbs;

  public function init(Request $request)
  {
    $this->breadcrumbs = $this->get('white_october_breadcrumbs');
    $this->breadcrumbs->addItem('Dashboard', $this->get('router')->generate('dashboard'));
  }

  /**
   * Add a submit button and a cancel button to a form.
   *
   * @param Form $form
   *   The form.
   * @param string $cancelUrl
   *   The cancel url.
   *
   * @return Form
   *   The form with the buttons added.
   */
  protected function addSubmit(Form $form, $submitLabel, $cancelUrl, $cancelLabel) {
    $buttons = array();
    if ($cancelUrl) {
      $buttons['cancel'] = array(
        'type' => 'button',
        'options' => array(
          'label' => $cancelLabel,
          'button_class' => 'default',
          'attr' => array(
            'onclick' => 'document.location.href = \'' . $cancelUrl . '\'',
          ),
        ),
      );
    }
    $buttons['submit'] = array(
      'type' => 'submit',
      'options' => array(
        'label' => $submitLabel,
      ),
    );

    $form->add('buttons', 'form_actions', array(
      'buttons' => $buttons
    ));

    return $form;
  }

  protected function addCreate(Form $form, $cancelUrl = NULL) {
    return $this->addSubmit($form, 'Create', $cancelUrl, 'Cancel');
  }

  protected function addUpdate(Form $form, $cancelUrl = NULL) {
    return $this->addSubmit($form, 'Update', $cancelUrl, 'Cancel');
  }

}
