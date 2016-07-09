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
use Rogiel\Bundle\UserBundle\Entity\Group;
use Rogiel\Bundle\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

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
            ->add('name', 'text')
            ->add('role', 'text')
            ->add('parent', 'sonata_type_model', array(
                'class' => 'Rogiel\Bundle\UserBundle\Entity\Group',
                'property' => 'name',
            ))
            ->end()
            ->with('Metadata', array('class' => 'col-md-4'))
            ->add('created_at', 'sonata_type_datetime_picker', array(
                'disabled'  => true,
                'required' => false
            ))
            ->add('updated_at', 'sonata_type_datetime_picker', array(
                'disabled'  => true,
                'required' => false
            ))
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
            ->add('name')
            ->add('role')
            ->add('parent.name')
            ->add('parent.role')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name')
            ->addIdentifier('role')
            ->addIdentifier('parent.name')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
            ->with('Content', array('class' => 'col-md-8'))
                ->add('name', 'text')
                ->add('role', 'text')
                ->add('parent', 'sonata_type_model', array(
                    'class' => 'Rogiel\Bundle\UserBundle\Entity\Group',
                    'associated_property' => 'name',
                ))
            ->end()
                ->with('Metadata', array('class' => 'col-md-4'))
                ->add('created_at', 'datetime')
                ->add('updated_at', 'datetime')
            ->end()
        ;
    }

    public function toString($object) {
        return $object instanceof Group
            ? $object->getName()
            : 'User Group'; // shown in the breadcrumb on the create view
    }
}