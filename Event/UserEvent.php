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
namespace Rogiel\Bundle\UserBundle\Event;

use Rogiel\Bundle\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event {

	const CREATE = 'rogiel.user.user.create';
	const EDIT = 'rogiel.user.user.edit';
	const DELETE = 'rogiel.user.user.delete';

	const UPDATE_PASSWORD = 'rogiel.user.user.update_password';
	const VALIDATION_COMPLETE = 'rogiel.user.user.validation_complete';
	const VALIDATION_EXPIRED = 'rogiel.user.user.validation_expired';

	const LOGIN = 'rogiel.user.user.login';
	const LOGOUT = 'rogiel.user.user.logout';

	/**
	 * @var User
	 */
	private $user;

	/**
	 * UserEvent constructor.
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

}