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
namespace Rogiel\Bundle\UserBundle\Security;

use Facebook\Facebook;
use Rogiel\Bundle\UserBundle\Entity\Repository\UserRepository;
use Rogiel\Bundle\UserBundle\Entity\User;
use Rogiel\FacebookBundle\Security\FacebookUser;
use Roole\EventBundle\Entity\FacebookProfile;
use Roole\EventBundle\Entity\Publisher;
use Roole\EventBundle\Entity\Repository\FacebookProfileRepository;
use Roole\EventBundle\Entity\Repository\PublisherRepository;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface {

	/**
	 * @var UserRepository
	 */
	protected $userRepository;

    /**
     * @var string
     */
    protected $userClass;

	/**
	 * UserProvider constructor.
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository, $userClass) {
        $this->userRepository = $userRepository;
        $this->userClass = $userClass;
	}

	/**
	 * Loads the user for the given username.
	 *
	 * This method must throw UsernameNotFoundException if the user is not
	 * found.
	 *
	 * @param string $username The username
	 *
	 * @return UserInterface
	 *
	 * @throws UsernameNotFoundException if the user is not found
	 */
	public function loadUserByUsername($username) {
		$user = $this->userRepository->getUserByEmail($username);
		if($user == NULL) {
			throw new UsernameNotFoundException();
		}
		return $user;
	}

	/**
	 * Refreshes the user for the account interface.
	 *
	 * It is up to the implementation to decide if the user data should be
	 * totally reloaded (e.g. from the database), or if the UserInterface
	 * object can just be merged into some internal array of users / identity
	 * map.
	 *
	 * @param UserInterface $user
	 *
	 * @return UserInterface
	 *
	 * @throws UnsupportedUserException if the account is not supported
	 */
	public function refreshUser(UserInterface $loadedUser) {
		/** @var User $user */
		$user = $loadedUser;
		return $this->loadUserByUsername($user->getEmail());
	}

	/**
	 * Whether this provider supports the given user class.
	 *
	 * @param string $class
	 *
	 * @return bool
	 */
	public function supportsClass($class) {
		return $class == $this->userClass;
	}

}