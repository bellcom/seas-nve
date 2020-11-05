<?php

namespace AppBundle\Form\Type\RapportSektion;

use AppBundle\DBAL\Types\SlutanvendelseType;
use Braincrafted\Bundle\BootstrapBundle\Form\Type\BootstrapCollectionType;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnbefalingRapportSektionExtrasType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('type', ChoiceType::class, array(
                'choices' => SlutanvendelseType::getChoices(),
                'empty_value' => 'common.none',
            ))
            ->add('tidsforloebuger', TextType::class, array('required' => FALSE))
            ->add('pris', TextType::class, array('required' => FALSE))
            ->add('tidsforloebinfo', BootstrapCollectionType::class, array(
                'property_path' => '[tidsforloebinfo]',
                'type' => new AnbefalingTidsforloebInfoEmbedType(),
                'required' => FALSE,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                'add_button_text'    => 'Add',
                'delete_button_text' => 'Delete',
                'sub_widget_col'     => 10,
                'button_col'         => 2,
            ))
            ->add('ressourcertekst', 'ckeditor', [
                'attr' => [
                    'maxlength' => 10000,
                    'class' => 'js-default-value-target js-default-value-target',
                    'data-default-value-source' => 'tidsforloeb_undertekst',
                ],
                'required' => FALSE,
            ])
            ->add('raadgiver', EntityType::class, array(
                'class' => 'AppBundle:User',
                'choices' => $this->getUsersFromGroup('Rådgiver', $options['entity_manager']),
                'required' => FALSE,
                'empty_value' => 'common.none',
            ))
            ->add('telefon', TextType::class, array('required' => FALSE))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setRequired('entity_manager');
    }

    /**
     * Gets the user of specific group.
     *
     * @param $groupname
     *   Name of the group.
     * @param EntityManagerInterface $em
     *   Entity manager.
     *
     * @return array
     *   List of users.
     */
    private function getUsersFromGroup($groupname, EntityManagerInterface $em) {
        $group = $em->getRepository('AppBundle:Group')->findOneByName($groupname);

        return empty($group) ? array() : $group->getUsers();
    }
}
