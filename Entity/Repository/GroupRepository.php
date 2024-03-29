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

namespace Rogiel\Bundle\UserBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Rogiel\Bundle\UserBundle\Entity\User;
use Rogiel\Bundle\UserBundle\Entity\Group;

/**
 * GroupRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupRepository extends EntityRepository {

    const DEFAULT_ROLE = 'ROLE_USER';

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * Gets the default user group for new accounts
     *
     * @return Group
     */
    public function getDefaultGroup() {
        return $this->findOneBy(['role' => self::DEFAULT_ROLE]);
    }

    // -----------------------------------------------------------------------------------------------------------------

	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	public function createQuery() {
		$query = self::createQueryBuilder('g');
		return $query;
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager() {
		return parent::getEntityManager();
	}

	/**
	 * @param Group $group the group to be persisted
	 */
	public function persist(Group $group) {
		$this->getEntityManager()->persist($group);
	}

	/**
	 * @param Group $group the group to be flushed
	 */
	public function flush(Group $group) {
		$this->getEntityManager()->flush($group);
	}

	/**
	 * @param Group $group the group to be checked
	 * @return bool true if the repository contains the given entity
	 */
	public function contains(Group $group) {
		return $this->getEntityManager()->contains($group);
	}

	/**
	 * @param Group $group the group to be removed
	 */
	public function remove(Group $group) {
		$this->getEntityManager()->remove($group);
	}

	/**
	 * @param Group $group the group to be refreshed
	 */
	public function refresh(Group $group) {
		$this->getEntityManager()->refresh($group);
	}

	/**
	 * @param Group $group the group to be merged
	 */
	public function merge(Group $group) {
		$this->getEntityManager()->merge($group);
	}

}
