<?php

/**
 * Rogiel Bundles
 * RogielUserBundle
 *
 * @link http://www.rogiel.com/
 * @copyright Copyright (c) 2016 Rogiel Sulzbach (http://www.rogiel.com)
 * @license Proprietary
 *
 * This bundle and its related source files can only be used under
 * explicit licensing from it's authors.
 */
namespace Rogiel\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $admin = isset($options['admin']) && ($options['admin'] == true);
        $register = isset($options['register']) && ($options['register'] == true);

        $builder->add('email', TextType::class, array(
            'disabled' => ($admin || $register ? false : true)
        ));

        if($register) {
            $builder->add('plainPassword', PasswordType::class, array(
                'empty_data' => null,
                'required' => true,
                'label' => 'Password',
                'constraints' => [
                    new NotBlank(),
                ],
            ));
        } else {
            $builder->add('plainPassword', PasswordType::class, array(
                'empty_data' => null,
                'required' => false,
                'label' => 'Password'
            ));
        }

        $builder->add('name', TextType::class, array());
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Rogiel\Bundle\UserBundle\Entity\User',
            'admin' => false,
            'register' => false
        ));
        $resolver->addAllowedValues('admin', [true, false]);
        $resolver->addAllowedValues('register', [true, false]);
    }
}
