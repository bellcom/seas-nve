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
  protected $flash;

  public function init(Request $request)
  {
    $this->breadcrumbs = $this->get('white_october_breadcrumbs');
    $this->breadcrumbs->addItem('common.forside', $this->get('router')->generate('dashboard_default'));
    $this->flash = $this->get('braincrafted_bootstrap.flash');
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
            'class' => 'pinned',
          ),
        ),
      );
    }
    $buttons['submit'] = array(
      'type' => 'submit',
      'options' => array(
        'label' => $submitLabel,
        'attr' => array(
          'class' => 'pinned',
        ),
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

  protected function addUpdate(Form $form, $cancelUrl = NULL, $label = 'Update') {
    return $this->addSubmit($form, $label, $cancelUrl, 'Cancel');
  }

  public function redirectToReferer(Request $request) {
    return $this->redirect($request->headers->get('referer'));
  }

}
