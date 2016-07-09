<?php

namespace AlbumGalleryBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AlbumRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlbumRepository extends EntityRepository
{
	private $prepage = 10;

	public function pagination($page = 0)
	{
		return $this->createQueryBuilder('p')
			->setMaxResults($this->prepage)
			->setFirstResult(($page -1) * $this->prepage)
			->getQuery()
			->execute();
	}

	public function exist($albumId)
	{
		return (int)$this->createQueryBuilder('u')
			->select('count(u.id)')
			->where('u.id = :id')
			->setParameter('id', $albumId)
			->getQuery()
			->getSingleScalarResult() > 0;
	}
}