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

namespace Rogiel\Bundle\UserBundle\Admin;

use Rogiel\Bundle\BlogBundle\Entity\Author;
use Rogiel\Bundle\BlogBundle\Entity\Category;
use Rogiel\Bundle\BlogBundle\Entity\Post;
use Rogiel\Bundle\GravatarBundle\Twig\Extension\GravatarExtension;
use Rogiel\Bundle\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAdmin extends AbstractAdmin {
    protected $baseRouteName = 'rogiel_user_admin_user';
    protected $baseRoutePattern = 'user';
    protected $searchResultActions = array('show', 'edit');

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Content', array('class' => 'col-md-8'))
            ->add('name', TextType::class, array(
                'help' => 'The user full name'
            ))
            ->add('email', TextType::class, array(
                'help' => 'The user email'
            ))
            ->add('plainPassword', PasswordType::class, array(
                'help' => 'The user password'
            ))
            ->add('group', ModelType::class, array(
                'property' => 'name',
                'help' => 'The user group'
            ))
            ->end()
            ->with('Metadata', array('class' => 'col-md-4'))
            ->add('created_at', DateTimePickerType::class, array(
                'disabled'  => true,
                'required' => false
            ))
            ->add('updated_at', DateTimePickerType::class, array(
                'disabled'  => true,
                'required' => false
            ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('name')
            ->add('email')
            ->add('group.name')
            ->add('group.role')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('email')
            ->addIdentifier('group.name')
            ->add('_action', NULL, array(
                'actions' => array(
                    'show'   => array(),
                    'edit'   => array(),
                    'delete' => array()
                ),
                'label'   => 'Actions'
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
            ->with('Content', array('class' => 'col-md-8'))
            ->add('name', TextType::class)
            ->add('email', TextType::class)
            ->add('group', ModelType::class, array(
                'associated_property' => 'name',
                'help' => 'The user group'
            ))
            ->end()
            ->with('Metadata', array('class' => 'col-md-4'))
            ->add('created_at', 'datetime')
            ->add('updated_at', 'datetime')
            ->end()
        ;
    }

    /**
     * @inheritDoc
     */
    public function prePersist($object) {
        /** @var User $user */
        $user = $object;
        if($user->getPlainPassword()) {
            $encoder = $this->getConfigurationPool()->getContainer()->get('security.password_encoder');
            $encodedPassword = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encodedPassword);
        }
    }

    public function toString($object) {
        return $object instanceof User
            ? $object->getName()
            : 'User'; // shown in the breadcrumb on the create view
    }

    public function getObjectMetadata($object) {
        if(!$object instanceof User) {
            return NULL;
        }
        $ext = new GravatarExtension();
        return new Metadata($object->getName(), $object->getGroup()->getName(), $ext->gravatar($object->getEmail()), array(
            'width' => 128,
            'height' => 128
        ));
    }
}