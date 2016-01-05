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
namespace Rogiel\Bundle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	public function indexAction() {
		return $this->render('RogielUserBundle:Default:index.html.twig');
	}
}
