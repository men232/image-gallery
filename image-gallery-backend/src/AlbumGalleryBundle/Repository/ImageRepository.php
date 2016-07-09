<?php

namespace AlbumGalleryBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends EntityRepository
{
	private $prepage = 10;

	public function pagination($page = 0, $albumId = null)
	{
		$qb = $this->createQueryBuilder('u');

		if (!is_null($albumId)) {
			$qb->where('u.album = :albumId')
			->setParameter('albumId', $albumId);
		}

		return $qb->setMaxResults($this->prepage)
			->setFirstResult(($page -1) * $this->prepage)
			->getQuery()
			->execute();
	}

	public function count($albumId)
	{
		return (int)$this->createQueryBuilder('u')
			->select('count(u.id)')
			->where('u.album = :albumId')
			->setParameter('albumId', $albumId)
			->getQuery()
			->getSingleScalarResult();
	}
}
