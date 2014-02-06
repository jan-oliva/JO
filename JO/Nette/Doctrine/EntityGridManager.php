<?php

namespace JO\Nette\Doctrine;

use Doctrine\ORM\EntityManager;
use \PM\DataGrid\DataGrid;

/**
 * Description of EntityGridManager
 * Support creating data grid from Doctrine entity.
 *
 * @author Jan Oliva
 */
class EntityGridManager
{
	/**
	 *
	 * @var DataGrid
	 */
	protected $dg;

	/**
	 *
	 * @var EntityManager
	 */
	protected $em;


	protected $entity;

	/**
	 *
	 * @var \Doctrine\ORM\Mapping\ClassMetadata
	 */
	protected $metaData;

	/**
	 *
	 * @param object $entity
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \PM\DataGrid\DataGrid $dg
	 */
	function __construct($entity, \Doctrine\ORM\EntityManager $em,$dg=null)
	{
		if(is_null($dg)){
			$dg = new DataGrid();
		}
		$this->entity = $entity;
		$this->dg = $dg;
		$this->em = $em;
		$this->metaData = $this->em->getClassMetadata($this->entity);
	}

	/**
	 * Add cols to data grid by properties in entity.
	 *
	 * @param array $cols - whitelist of columns
	 */
	public function addCols($cols=array())
	{
		foreach ($this->metaData->getColumnNames() as $prop){
			$fieldName = $prop;
			$caption = $this->parseFormLabel($prop);
			if($this->isIncluded($prop, $cols)){
				$this->dg->addColumn($fieldName, $caption);
			}

		}
	}

	private function isIncluded($item,$exclude)
	{
		return in_array($item, $exclude);
	}

	/**
	 * Return label of proprerty from entity.
	 * Use special anotation #formLabel="my label"
	 *
	 * @param string $prop
	 * @return string
	 */
	protected function parseFormLabel($prop)
	{
		$rp = $this->metaData->getReflectionProperty($prop);
				/* @var $rp \ReflectionProperty */
		$comment = $rp->getDocComment();
		if(preg_match('/#formLabel="(.*)"/', $comment,$matches)){
			return $matches[1];
		}
		return $prop;
	}
}
