<?php

namespace JO\Nette\Doctrine;

use Doctrine\ORM\EntityManager;
use \PM\DataGrid\DataGrid;

/**
 * Description of EntityGridManager
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

	public function addCols($exclude=array())
	{
		foreach ($this->metaData->getColumnNames() as $prop){
			$fieldName = $prop;

			if(!$this->isIncluded($prop, $exclude)){
				continue;
			}
			$caption = $this->parseFormLabel($prop);
			$fieldType = $this->metaData->getTypeOfColumn($prop);
			switch($fieldType){
				case 'boolean' :
					$this->dg->addCheckboxColumn($fieldName, $caption);
					break;
				default:
					$this->dg->addColumn($fieldName, $caption);
					break;
			}

		}
	}

	private function isIncluded($item,$exclude)
	{
		return in_array($item, $exclude);
	}

	private function parseFormLabel($prop)
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
