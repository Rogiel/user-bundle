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
namespace Rogiel\Bundle\UserBundle\DependencyInjection;

use Rogiel\Bundle\UserBundle\Entity\Group;
use Rogiel\Bundle\UserBundle\Entity\User;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface {
	/**
	 * {@inheritdoc}
	 */
	public function getConfigTreeBuilder() {
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('rogiel_user');

        $rootNode
            ->children()
                ->scalarNode('user_class')
                    ->defaultValue(User::class)
                ->end()
                ->scalarNode('group_class')
                    ->defaultValue(Group::class)
                ->end()
            ->end()
        ;

		return $treeBuilder;
	}
}
