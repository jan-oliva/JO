<?php

namespace JO\Nette\Doctrine;

use Doctrine\ORM\EntityManager;
use Nette\Application\UI\Form;
use Nette\Diagnostics\Debugger;

/**
 * Description of EntityFormManager
 *
 * Vytvari prvky formu dle entity.
 * Popisky poli dle #formLabel="xxx"
 * Napr.
 *  @column(type="integer") #formLabel="Unit amount"
 *	protected $count;
 *
 * Generuje instanci entity s hodnotami z formulare.
 * Nedoplnuje asociovane vlastnosti
 *
 * @author Jan Oliva
 */
class EntityFormManager
{
	const FORM_FIELD_PREFIX = 'F_';
	/**
	 *
	 * @var Form
	 */
	protected $form;

	/**
	 *
	 * @var string
	 */
	protected $entity;

	/**
	 *
	 * @var \ReflectionClass
	 */
	protected $reflection;

	/**
	 *
	 * @var string
	 */
	protected $formFieldPrefix;

	/**
	 *
	 * @var EntityManager
	 */
	protected $em;

	/**
	 *
	 * @var \Doctrine\ORM\Mapping\ClassMetadata
	 */
	protected $metaData;

	private $dateType = \IntlDateFormatter::MEDIUM;

	private $timeType = \IntlDateFormatter::NONE;

	private $timeZone = 'Europe/Prague';

	function __construct(Form $form, $entity,  EntityManager $em,$formFieldPrefix=self::FORM_FIELD_PREFIX)
	{
		$this->form = $form;
		if(!$this->isEntity($entity)){
			throw new \BadMethodCallException("Second argumet '{$entity}' is not valid Doctrine Entiry class");
		}
		$this->entity = $entity;
		$this->em = $em;
		$this->formFieldPrefix = $formFieldPrefix;
		$this->metaData = $this->em->getClassMetadata($this->entity);
	}

	private function isEntity($entity)
	{
		$this->reflection = new \ReflectionClass($entity);
		$comment = $this->reflection->getDocComment();
		return (bool)strpos($comment, '@entity');

	}

	/**
	 *
	 * @param string $prefix
	 * @param array $exclude
	 */
	public function getFormCols($exclude=array())
	{
		$props = $this->reflection->getProperties();
		$ret = array();

		foreach ($props as $prop){
			/* @var $prop \ReflectionProperty */
			if($prop->isProtected() && !in_array($prop->getName(), $exclude)){

				$ret[] = $prop;
			}
		}
		return $ret;

	}

	/**
	 * Doplni do formulare polozky dle entity.
	 * U asociovanych vlastnosti vytvari select, jinak text pole.
	 * @param type $exclude
	 */
	public function createFileds($exclude=array())
	{
		//asociovana data->relace je select box
		foreach ($this->metaData->getAssociationNames()as $prop){
			if(!$this->isExcluded($prop, $exclude)){
				$fieldName = $this->formFieldPrefix.$prop;
				$caption = $this->parseFormLabel($prop);
				$this->form->addSelect($fieldName, $caption);
			}
		}
		//realne sloupce tabulky
		foreach ($this->metaData->getColumnNames() as $prop){
			$fieldName = $this->formFieldPrefix.$prop;
			$caption = $this->parseFormLabel($prop);
			if(!$this->isExcluded($prop, $exclude)){
				$this->form->addText($fieldName, $caption);
			}

		}

	}

	private function isExcluded($item,$exclude)
	{
		return in_array($item, $exclude);
	}

	/**
	 * Hleda v anotaci vlastonosti #formLabel="popis pole"
	 * @param type $prop
	 * @return string
	 */
	private function parseFormLabel($prop)
	{
		$rp = $this->metaData->getReflectionProperty($prop);
				/* @var $rp \ReflectionProperty */
		$comment = $rp->getDocComment();
		if(preg_match('/#formLabel="(.*)"/', $comment,$matches)){
			return $matches[1];
		}
		return $this->formFieldPrefix.$prop;
	}

	/**
	 * Vrati entitu s predvyplnenymi hodnotami dle formulare.
	 * Pozor - doplnuje jen hodnoty, ktere nemaji asociaci do jine entity a skalarni hodnoty
	 * @param array $excludeInputs
	 * @return object Entity
	 */
	public function createEntityFromForm($excludeInputs=array())
	{
		$instance = $this->reflection->newInstance();
		foreach ((array)$this->form->getValues() as $key=>$val){

			if($this->isExcluded($key, $excludeInputs)){
				continue;
			}

			$prop = str_replace($this->formFieldPrefix, '', $key);
			if($this->metaData->hasAssociation($prop)){
				continue;

			}
			$method = "set".ucfirst(str_replace($this->formFieldPrefix, '', $key));

			if(is_scalar($val) && $this->reflection->hasMethod($method)){
				call_user_func(array($instance,$method),$val);
			}
		}
		return $instance;
	}

	private function itemName2prop($key)
	{
		return str_replace($this->formFieldPrefix, '', $key);
	}

	private function composeGetterName($prop)
	{
		return $method = "get".ucfirst($prop);
	}

	/**
	 * Doplni form hodnoty z entity
	 * @param type $entity
	 * @param type $locale
	 */
	public function fillFormFromEntity($entity,$locale='cs_CZ')
	{

		foreach ($this->form->getControls() as $element){
			$prop = $this->itemName2prop($element->getName());
			$getter = $this->composeGetterName($prop);

			if(method_exists($entity, $getter)){

				$val = call_user_func(array($entity,$getter));
				//\Nette\Diagnostics\Debugger::barDump($val);
				if($val instanceof \DateTime){
					$fmt= new \IntlDateFormatter($locale, $this->dateType, $this->timeType, $this->timeZone);
					$element->setValue($fmt->format($val));

				}elseif(is_scalar($val)){
					$element->setValue($val);

				}
			}
		}

	}
}
