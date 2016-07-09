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
namespace Rogiel\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="email", columns={"email"})
 * })
 * @ORM\Entity(repositoryClass="Rogiel\Bundle\UserBundle\Entity\Repository\UserRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 *
 * @AssertORM\UniqueEntity(fields={"email"})
 */
class User implements UserInterface {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="userid", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="email", type="string", length=100, nullable=false)
	 *
	 * @Assert\Email()
	 * @Assert\NotBlank()
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=100, nullable=false)
	 *
	 * @Assert\NotBlank()
	 */
	private $name;

	/**
	 * @var Group
	 *
	 * @ORM\ManyToOne(targetEntity="Rogiel\Bundle\UserBundle\Entity\Group", inversedBy="users", fetch="EAGER")
	 * @ORM\JoinColumns({
	 *  @ORM\JoinColumn(name="groupid", referencedColumnName="groupid")
	 * })
	 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
	 */
	private $group;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", nullable=false)
	 */
	private $password;

	/**
	 * The publshers plain password
	 *
	 * @var string
	 *
	 * @Assert\Length(min="6")
	 */
	private $plainPassword;

	// -----------------------------------------------------------------------------------------------------------------

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="created_at", type="datetime", nullable=false)
	 */
	private $createdAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="updated_at", type="datetime", nullable=false)
	 */
	private $updatedAt;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="last_login_at", type="datetime", nullable=true)
	 */
	private $lastLoginAt;

	// -----------------------------------------------------------------------------------------------------------------

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->createdAt = new \DateTime();
		$this->updatedAt = $this->createdAt;
	}

	// -----------------------------------------------------------------------------------------------------------------

	/**
	 * @return int
	 */
	public function getID() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return User
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return User
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * Set group
	 *
	 * @param \Rogiel\Bundle\UserBundle\Entity\Group $group
	 *
	 * @return User
	 */
	public function setGroup(Group $group) {
		$this->group = $group;

		return $this;
	}

	/**
	 * Get group
	 *
	 * @return \Rogiel\Bundle\UserBundle\Entity\Group
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * @return mixed
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param mixed $password
	 * @return User
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPlainPassword() {
		return $this->plainPassword;
	}

	/**
	 * @param string $plainPassword
	 * @return User
	 */
	public function setPlainPassword($plainPassword) {
		$this->plainPassword = $plainPassword;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt() {
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 * @return User
	 */
	public function setCreatedAt($createdAt) {
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * @param \DateTime $updatedAt
	 * @return User
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastLoginAt() {
		return $this->lastLoginAt;
	}

	/**
	 * @param \DateTime $lastLoginAt
	 * @return User
	 */
	public function setLastLoginAt($lastLoginAt) {
		$this->lastLoginAt = $lastLoginAt;
		return $this;
	}


	// -----------------------------------------------------------------------------------------------------------------

	/**
	 * @inheritDoc
	 */
	public function getRoles() {
		return $this->group->getRoles();
	}

	/**
	 * @inheritDoc
	 */
	public function getSalt() {
		return NULL;
	}

	/**
	 * @inheritDoc
	 */
	public function getUsername() {
		return $this->getEmail();
	}

	/**
	 * @inheritDoc
	 */
	public function eraseCredentials() {
		$this->plainPassword = NULL;
	}
}
