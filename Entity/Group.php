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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints as AssertORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user_group", uniqueConstraints={
 *      @ORM\UniqueConstraint(name="name", columns={"name"})
 * })
 * @ORM\Entity(repositoryClass="Rogiel\Bundle\UserBundle\Entity\Repository\GroupRepository")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 *
 * @AssertORM\UniqueEntity(fields={"name"})
 */
class Group {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="groupid", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	private $id;

	/**
	 * @var Group
	 *
	 * @ORM\ManyToOne(targetEntity="Rogiel\Bundle\UserBundle\Entity\Group", fetch="EAGER")
	 * @ORM\JoinColumns({
	 *  @ORM\JoinColumn(name="parent_group", referencedColumnName="groupid")
	 * })
	 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
	 */
	private $parent;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="name", type="string", length=100, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Length(min=1)
	 */
	private $name;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="role", type="string", length=100, nullable=false)
	 *
	 * @Assert\NotBlank()
	 * @Assert\Regex(pattern="ROLE_(.*)")
	 */
	private $role;

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

	// -----------------------------------------------------------------------------------------------------------------

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(mappedBy="group", targetEntity="Rogiel\Bundle\UserBundle\Entity\User", fetch="LAZY")
	 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
	 */
	private $users;

	// -----------------------------------------------------------------------------------------------------------------

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->createdAt = new \DateTime();
		$this->updatedAt = $this->createdAt;
		$this->users = new ArrayCollection();
	}

	// -----------------------------------------------------------------------------------------------------------------

    /**
     * Get id
     *
     * @return integer
     */
    public function getID() {
        return $this->id;
    }

	/**
	 * @return Group
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param Group $parent
	 * @return Group
	 */
	public function setParent($parent) {
		$this->parent = $parent;
		return $this;
	}

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Group
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

	/**
	 * @return string
	 */
	public function getRole() {
		return $this->role;
	}

	/**
	 * @param string $role
	 * @return Group
	 */
	public function setRole($role) {
		$this->role = $role;
		return $this;
	}

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Group
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Group
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * Add user
     *
     * @param User $user
     *
     * @return Group
     */
    public function addUser(User $user) {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user) {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers() {
        return $this->users;
    }

	/**
	 * Fetches the group roles
	 */
	public function getRoles() {
		if($this->parent != NULL) {
			return array_merge($this->parent->getRoles(), [$this->role]);
		}
		return [$this->role];
	}
}
