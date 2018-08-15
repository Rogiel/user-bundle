<?php
/**
 * Rogiel Bundles
 * RogielUserBundle
 *
 * @link      http://www.rogiel.com/
 * @copyright Copyright (c) 2016 Rogiel Sulzbach (http://www.rogiel.com)
 * @license   Proprietary
 *
 * This bundle and its related source files can only be used under
 * explicit licensing from it's authors.
 */

namespace Rogiel\Bundle\UserBundle\Admin;

use Rogiel\Bundle\BlogBundle\Entity\Author;
use Rogiel\Bundle\BlogBundle\Entity\Category;
use Rogiel\Bundle\BlogBundle\Entity\Post;
use Rogiel\Bundle\UserBundle\Entity\Group;
use Rogiel\Bundle\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GroupAdmin extends AbstractAdmin {
    protected $baseRouteName = 'rogiel_user_admin_group';
    protected $baseRoutePattern = 'user/group';
    protected $searchResultActions = array('show', 'edit');

    /**
     * @inheritDoc
     */
    public function configure() {
        $this->showMosaicButton(false);
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->with('Content', array('class' => 'col-md-8'))
            ->add('name', TextType::class)
            ->add('role', TextType::class)
            ->add('parent', ModelType::class, array(
                'property' => 'name',
                'required' => false,
            ))
            ->end()
            ->with('Metadata', array('class' => 'col-md-4'))
            ->add('created_at', DateTimePickerType::class, array(
                'disabled' => true,
                'required' => false
            ))
            ->add('updated_at', DateTimePickerType::class, array(
                'disabled' => true,
                'required' => false
            ))
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('name')
            ->add('role')
            ->add('parent.name')
            ->add('parent.role');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('role')
            ->addIdentifier('parent',ModelType::class, array(
                'associated_property' => 'name',
                'required' => false
            ))
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
            ->add('role', TextType::class)
            ->add('parent', ModelType::class, array(
                'associated_property' => 'name',
                'required'            => false
            ))
            ->end()
            ->with('Metadata', array('class' => 'col-md-4'))
            ->add('created_at', 'datetime')
            ->add('updated_at', 'datetime')
            ->end();
    }

    public function toString($object) {
        return $object instanceof Group
            ? $object->getName()
            : 'User Group'; // shown in the breadcrumb on the create view
    }
}