<?php

namespace JO\Model\Doctrine;

use Doctrine\ORM\EntityManager;

/**
 * Description of AModel
 *
 * @author Jan Oliva
 */
class AModel implements IModel
{
	/**
	 *
	 * @var EntityManager
	 */
	protected $em;

	function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	/**
	 *
	 * {@inheritdoc}
	 */
	public function getEntityManager()
	{
		return $this->em;
	}



}
