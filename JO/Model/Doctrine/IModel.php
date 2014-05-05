<?php

namespace JO\Model\Doctrine;

/**
 *
 * @author Jan Oliva
 */
interface IModel
{
	/**
	 * 
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager();
}
