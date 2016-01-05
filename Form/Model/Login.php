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
namespace Rogiel\Bundle\UserBundle\Form\Model;

class Login {

	private $email;
	private $password;

	private $rememberMe;

	/**
	 * @return mixed
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param mixed $email
	 * @return Login
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param mixed $password
	 * @return Login
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getRememberMe() {
		return $this->rememberMe;
	}

	/**
	 * @param mixed $rememberMe
	 * @return Login
	 */
	public function setRememberMe($rememberMe) {
		$this->rememberMe = $rememberMe;
		return $this;
	}

}