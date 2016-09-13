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
namespace Rogiel\Bundle\UserBundle\Service;

use Rogiel\Bundle\UserBundle\Entity\Repository\GroupRepository;
use Rogiel\Bundle\UserBundle\Entity\User;
use Rogiel\Bundle\UserBundle\Entity\Repository\UserRepository;
use Rogiel\Bundle\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var GroupRepository
     */
    private $groupRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @var string
     */
    private $defaultUserGroupRole;

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * UserService constructor.
     *
     * @param UserRepository               $userRepository
     * @param GroupRepository              $groupRepository
     * @param EventDispatcherInterface     $eventDispatcher
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserRepository $userRepository,
                                GroupRepository $groupRepository,
                                EventDispatcherInterface $eventDispatcher,
                                UserPasswordEncoderInterface $passwordEncoder, $defaultUserGroupRole = 'ROLE_USER') {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->passwordEncoder = $passwordEncoder;
        $this->defaultUserGroupRole = $defaultUserGroupRole;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @param User $user
     *
     * @return User
     */
    public function create(User $user) {
        if ($this->userRepository->contains($user)) {
            return NULL;
        }

        if ($user->getGroup() == NULL) {
            // assign user to the default group
            $user->setGroup($this->groupRepository->findOneBy(['role' => $this->defaultUserGroupRole]));
        }

        $this->updatePasswordIfNeeded($user);

        $this->userRepository->persist($user);
        $this->userRepository->flush($user);

        $this->eventDispatcher->dispatch(
            UserEvent::CREATE,
            new UserEvent($user)
        );

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function edit(User $user) {
        if (!$this->userRepository->contains($user)) {
            return NULL;
        }

        $this->updatePasswordIfNeeded($user);

        $this->userRepository->persist($user);
        $this->userRepository->flush($user);

        $this->eventDispatcher->dispatch(
            UserEvent::EDIT,
            new UserEvent($user)
        );

        return $user;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user) {
        if (!$this->userRepository->contains($user)) {
            return false;
        }

        $this->userRepository->remove($user);
        $this->userRepository->flush($user);

        $this->eventDispatcher->dispatch(
            UserEvent::DELETE,
            new UserEvent($user)
        );

        return true;
    }

    // -----------------------------------------------------------------------------------------------------------------

    private function updatePasswordIfNeeded(User $user) {
        if ($user->getPlainPassword() != NULL) {
            $encodedPassword = $this->passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );

            $user->setPassword($encodedPassword);
            $user->eraseCredentials();
        }

    }


}