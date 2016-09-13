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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller {

	/**
	 * @Route(name="rogiel_user_login", path="/login")
	 */
	public function loginAction(Request $request) {
        if($this->getUser() != NULL) {
            throw $this->createNotFoundException();
        }

		$authenticationUtils = $this->get('security.authentication_utils');

		// get the login error if there is one
		$error = $authenticationUtils->getLastAuthenticationError();

		// last username entered by the user
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render(
			'RogielUserBundle:Login:login.html.twig',
			array(
				// last username entered by the user
				'last_username' => $lastUsername,
				'error'         => $error,
			)
		);
	}

	/**
	 * @Route("/login_check", name="rogiel_user_login_check")
	 */
	public function loginCheckAction(Request $request) { }

	/**
	 * @Route("/logout", name="rogiel_user_logout")
	 */
	public function logoutAction() {
		// this controller will not be executed,
		// as the route is handled by the Security system
	}

}
