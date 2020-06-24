<?php
/**
 * @file
 * @TODO: Missing description.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
   * @param string $submitKey
   *   Key for submit button.
   * @param string $cancelUrl
   *   The cancel url.
   * @param string $cancelLabel
   *   Label for cancel key.
   *
   * @return Form
   *   The form with the buttons added.
   */
  protected function addSubmit(Form $form, $submitLabel, $submitKey = 'submit', $options = array(), $cancelUrl = FALSE, $cancelLabel = 'Cancel') {
    // Creating form actions wrapper if empty.
    if (!$form->has('buttons')) {
      $buttons = array();
      $form->add('buttons', 'form_actions', array(
        'buttons' => $buttons
      ));
    }
    $buttons_element = $form->get('buttons');

    if ($cancelUrl) {
      $buttons_element->add('cancel',  'button', array(
        'label' => $cancelLabel,
        'button_class' => 'default',
        'attr' => array(
          'onclick' => 'document.location.href = \'' . $cancelUrl . '\'',
          'class' => empty($options['pinned']) ? '' : 'pinned',
        ),
      ));
    }
    $submit_options = array(
      'label' => $submitLabel,
      'attr' => array(),
    );
    if (!empty($options['attr'])) {
      $submit_options['attr'] = $options['attr'];
    }
    if (!empty($options['pinned'])) {
      if (empty($submit_options['attr']['class'])) {
        $submit_options['attr']['class'] = '';
      }
      $submit_options['attr']['class'] .= 'pinned';
    }
    $options['label'] = $submitLabel;
    $buttons_element->add($submitKey, SubmitType::class, $submit_options);

    return $form;
  }

  protected function addCreate(Form $form, $cancelUrl = NULL, $options = array(), $pinned = TRUE) {
    return $this->addSubmit($form, 'Create','submit', array_merge_recursive(array('pinned' => $pinned), $options), $cancelUrl, 'Cancel');
  }

  protected function addUpdate(Form $form, $cancelUrl = NULL, $label = 'Save', $pinned = TRUE) {
    return $this->addSubmit($form, $label,'submit', array('pinned' => $pinned), $cancelUrl, 'Cancel');
  }

  protected function addLinkButton(Form $form, $key, $url, $label, $pinned = TRUE) {
    // Creating form actions wrapper if empty.
    if (!$form->has('buttons')) {
      $buttons = array();
      $form->add('buttons', 'form_actions', array(
        'buttons' => $buttons
      ));
    }
    $buttons_element = $form->get('buttons');

    $button_options = array(
      'label' => $label,
      'button_class' => 'default',
      'attr' => array(
        'onclick' => 'document.location.href = \'' . $url . '\'',
        'class' => $pinned ? 'pinned' : '',
      ),
    );
    $buttons_element->add($key, 'button', $button_options);

    return $form;
  }

  protected function addUpdateAndExit(Form $form, $url = NULL, $label = 'Save and exit', $pinned = TRUE) {
    return $this->addSubmit($form, $label, 'save_and_exit', array(
        'pinned' => $pinned,
        'attr' => array(
          'destination' => $url
        )
      )
    );
  }

  public function redirectToReferer(Request $request) {
    return $this->redirect($request->headers->get('referer'));
  }

  public function getButtonDestination(Button $button) {
    if (!empty($button) && $button->getConfig() instanceof ButtonBuilder) {
      $attr = $button->getConfig()->getOption('attr');
    }
    return empty($attr['destination']) ? FALSE : $attr['destination'];
  }

}
