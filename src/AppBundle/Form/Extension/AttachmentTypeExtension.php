<?php
/**
 *
 * @see http://symfony.com/doc/current/cookbook/form/create_form_type_extension.html
 */
namespace AppBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AttachmentTypeExtension extends AbstractTypeExtension {
  /**
   * Returns the name of the type being extended.
   *
   * @return string The name of the type being extended
   */
  public function getExtendedType() {
    return 'file';
  }

  /**
   * Add the image_path option
   *
   * @param OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver) {
    $resolver->setOptional(array('attachment_path'));
  }

  /**
   * Pass the attachment URL to the view
   *
   * @param FormView $view
   * @param FormInterface $form
   * @param array $options
   */
  public function buildView(FormView $view, FormInterface $form, array $options) {
    if (array_key_exists('attachment_path', $options)) {
      $parentData = $form->getParent()->getData();

      if (null !== $parentData) {
        $accessor = PropertyAccess::createPropertyAccessor();
        $attachmentUrl = $accessor->getValue($parentData, $options['attachment_path']);
      } else {
        $attachmentUrl = null;
      }

      // set an "attachment_url" variable that will be available when rendering this field
      $view->vars['attachment_url'] = $attachmentUrl;
    }
  }

}
