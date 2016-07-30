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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class RogielUserExtension extends Extension implements PrependExtensionInterface {
	/**
	 * {@inheritdoc}
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);

		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.yml');

        $container->setParameter('rogiel_user.user_class', $config['user_class']);
        $container->setParameter('rogiel_user.group_class', $config['group_class']);
	}

    /**
     * @inheritDoc
     */
    public function prepend(ContainerBuilder $container) {
        $bundles = $container->getParameter('kernel.bundles');
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        if (isset($bundles['SonataAdminBundle'])) {
            $loader->load('sonata_admin.yml');
        }
        $loader->load('security.yml');
    }

}
