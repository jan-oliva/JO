<?php

namespace JO\Nette\Doctrine;

use Doctrine\ORM\EntityManager;
use Grido\Grid;

/**
 * Description of EntityGridManager
 *
 * Entity manager for data grid Grido\Grid
 *
 * Works with extension Kdyby/Doctrine
 * @see http://travis-ci.org/Kdyby/Doctrine
 *
 * @author Jan Oliva
 *
 * @see http://o5.github.io/grido-sandbox/index.html
 */
class EntityGridoManager
{
	/**
	 *
	 * @var Grid
	 */
	protected $dg;

	/**
	 *
	 * @var EntityManager
	 */
	protected $em;

	protected $entity;

	protected $cols = array();

	/**
	 *
	 * @var \Doctrine\ORM\Mapping\ClassMetadata
	 */
	protected $metaData;

	/**
	 *
	 * @param string $entity
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param \Grido\Grid $dg
	 */
	function __construct($entity, \Doctrine\ORM\EntityManager $em,$dg=null)
	{
		if(is_null($dg)){
			$dg = new Grid();
		}
		$this->entity = $entity;
		$this->dg = $dg;
		$this->dg->rememberState = true;
		$this->em = $em;
		$this->metaData = $this->em->getClassMetadata($this->entity);
	}

	/**
	 * Add columns by entity fields by whitelist.
	 * Can filter and sorting on column
	 *
	 * DG methods by data type
	 *	- boolean	addColumnText
	 *	- integer	addColumnNumber
	 *  - other		addColumnText
	 *
	 * @param array $fieldWhitelist - strings of entity properties
	 * @param bool $autoAddFilter
	 */
	public function addCols($fieldWhitelist=array(),$autoAddFilter=false,$autoAddSort=false)
	{
		foreach ($this->metaData->getColumnNames() as $prop){
			$fieldName = $prop;

			if(!$this->isIncluded($prop, $fieldWhitelist)){
				continue;
			}
			$caption = $this->parseFormLabel($prop);
			$fieldType = $this->metaData->getTypeOfColumn($prop);

			switch($fieldType){
				case 'boolean' :
					$this->cols[$fieldName] = $this->dg->addColumnText($fieldName, $caption);
					break;
				case 'integer':
					$this->cols[$fieldName] = $this->dg->addColumnNumber($fieldName, $caption);

					if($autoAddFilter){
						$this->cols[$fieldName]->setFilterNumber();
					}
					break;
				default:
					$this->cols[$fieldName] = $this->dg->addColumnText($fieldName, $caption);
					if($autoAddFilter){
						$this->cols[$fieldName]->setFilterText();
					}
					break;
			}
			if($autoAddSort){
				$this->cols[$fieldName]->setSortable();
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

	public function getCols()
	{
		return $this->cols;
	}


}
