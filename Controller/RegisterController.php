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

use Rogiel\Bundle\UserBundle\Entity\User;
use Rogiel\Bundle\UserBundle\Form\Type\UserType;
use Rogiel\Bundle\UserBundle\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegisterController
 * @package Rogiel\Bundle\UserBundle\Controller
 *
 * @Route(service="rogiel_user.controller.register")
 */
class RegisterController extends Controller {

	/**
	 * @var UserService
	 */
	private $userService;

	/**
	 * RegisterController constructor.
	 * @param UserService $userService
	 */
	public function __construct(UserService $userService) {
		$this->userService = $userService;
	}

    /**
     * @Route(name="rogiel_user_register", path="/register")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
	public function registerAction(Request $request) {
	    $userClass = $this->container->getParameter('rogiel_user.user_class');
		$user = new $userClass;

		$form = $this->createForm(UserType::class, $user, ['register' => true])
			->add('submit', SubmitType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$this->userService->create($user);

			return $this->redirectToRoute('rogiel_user_validation_required');
		}

		return $this->render('RogielUserBundle:Register:register.html.twig', [
			'form' => $form->createView()
		]);
	}

	/**
	 * @Route(name="rogiel_user_validation_required", path="/registration_complete")
	 */
	public function validationRequiredAction() {
		return $this->render('RogielUserBundle:Register:validation_required.html.twig');
	}

	/**
	 * @Route(name="rogiel_user_validation", path="/registration_validate")
	 */
	public function validateAction() {

	}

}
