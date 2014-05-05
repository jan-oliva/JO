<?php

namespace JO\Nette\Doctrine;

use Doctrine\ORM\EntityManager;
use Nette\Application\UI\Form;
use Nette\Diagnostics\Debugger;

/**
 * Description of EntityFormManager
 *
 * Creates form elements by entity fileds.
 * Creates form labels by #formLabel="xxx"
 *
 * Example
 *  @column(type="integer") #formLabel="Unit amount"
 *	protected $count;
 *
 * Create0 instance of entity a and fill them by form values.
 * Don't fill fields with asociations.
 *
 * Works with extension Kdyby/Doctrine
 * @see http://travis-ci.org/Kdyby/Doctrine
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

	/**
	 *
	 * @param \Nette\Application\UI\Form $form
	 * @param object $entity
	 * @param \Doctrine\ORM\EntityManager $em
	 * @param string $formFieldPrefix - prefix pro nazev pole ve formulari. DFL 'F_'
	 * @throws \BadMethodCallException
	 */
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
		$stdEntity = (bool)strpos($comment, '@entity');
		$ormEntity = (bool)strpos($comment, '@ORM\Entity');
		$ormEntity1 = (bool)strpos($comment, '@Doctrine\ORM\Mapping\Entity');

		return $stdEntity || $ormEntity || $ormEntity1;

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
	 * Register form fields by entity.
	 * For associed fileds creates input select
	 * For boolean fields creates checkbox
	 * For datetime fields try call addDatePicker for show date picker
	 * For other columns creates input text
	 *
	 * @param array $exclude
	 * @param bool $itemsIsWhitelist - determine wheter items are white list or blacklist
	 * @param \Nette\Forms\Container $container If given, fields will be registered into container
	 */
	public function createFields($items=array(),$itemsIsWhitelist=false,\Nette\Forms\Container $container=null)
	{
		$testInclude = $itemsIsWhitelist;
		$object = ($container instanceof \Nette\Forms\Container) ? $container : $this->form;
		//associed filed  data->relace creates select box
		foreach ($this->metaData->getAssociationNames()as $prop){

			if(in_array($prop, $items) === $testInclude){
				$fieldName = $this->formFieldPrefix.$prop;
				$caption = $this->parseFormLabel($prop);
				$object->addSelect($fieldName, $caption);
			}

		}
		//columns of db table
		foreach ($this->metaData->getFieldNames() as $prop){

			$fieldName = $this->formFieldPrefix.$prop;
			if(in_array($prop, $items) !== $testInclude){
				continue;
			}
			if($this->metaData->hasAssociation($prop)){
				continue;
			}
			$caption = $this->parseFormLabel($prop);
			$fieldType = $this->metaData->getTypeOfColumn($prop);

			switch($fieldType){
				case 'boolean' :
					$object->addCheckbox($fieldName,$caption);
					break;
				case 'datetime' :
					if(is_callable(array($this->form,'addDatePicker'))){
						//rozsireni zakladniho nette formulare
						$object->addDatePicker($fieldName,$caption);
					}else{
						//zakladni form bez metodu addDatePicker
						$object->addText($fieldName, $caption);
					}
					break;
				default:
					$object->addText($fieldName, $caption);
					break;
			}

		}


	}

	private function isExcluded($item,$exclude)
	{
		return in_array($item, $exclude);
	}

	/**
	 * Find annotation #formLabel="UI form label of field"
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
	 * Creates entity and fill fomm values
	 * @param array $excludeInputs
	 * @param \Nette\Forms\Container $container
	 * @return object Entity
	 */
	public function createEntityFromForm($excludeInputs=array(),\Nette\Forms\Container $container=null)
	{
		$entity = $this->reflection->newInstance();
		return $this->fillEntityFromForm($entity,$excludeInputs,$container);
	}

	/**
	 * Fill entity by form values
	 * Attention - Fill only fields which has noassociation and scalar values
	 *
	 * @param object $entity
	 * @param array $excludeInputs
	 * @return object Entity
	 */
	public function fillEntityFromForm($entity,$excludeInputs=array(),\Nette\Forms\Container $container=null)
	{
		$instance =  $entity;
		$object = ($container instanceof \Nette\Forms\Container) ? $container : $this->form;
		foreach ((array)$object->getValues() as $key=>$val){

			if($this->isExcluded($key, $excludeInputs)){
				continue;
			}
			//form field name
			$prop = str_replace($this->formFieldPrefix, '', $key);
			if($this->metaData->hasAssociation($prop)){
				continue;

			}
			//no scalar values are not supported now
			if(!is_scalar($val)){
				continue;
			}

			//fom can have fields for more entities
			$keyTest = str_replace($this->formFieldPrefix, '', $key);
			$method = $this->composeSetterName($keyTest);

			if(!$this->metaData->hasField($keyTest)){
				continue;
			}
			$type = $this->metaData->getTypeOfColumn($keyTest);

			//datetime musi byt instance DateTime nebo null
			if($type === 'datetime' && $val === ''){
				$val = null;
			}elseif($type === 'datetime' && $val !== ''){
				$val = new \DateTime($val);
			}
			//call entity setter
			if(is_callable(array($instance,$method))){
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

	private function composeSetterName($prop)
	{
		return $method = "set".ucfirst($prop);
	}

	/**
	 * Fill form values from given entity.
	 *
	 * Accept
	 *  - scalar  values
	 *  - \DateTime object
	 * Other typs are skipped and form fileds not filled
	 *
	 * @param object $entity
	 * @param \Nette\Forms\Container $container
	 * @param string $locale - locale for \DateTime object. Example cs_CZ|en_US|sk_SK|hu_HU ...
	 */
	public function fillFormFromEntity($entity,\Nette\Forms\Container $container=null,$locale='cs_CZ')
	{
		$object = ($container instanceof \Nette\Forms\Container) ? $container : $this->form;
		foreach ($object->getControls() as $element){
			/* @var $element \Nette\Forms\Controls\BaseControl */
			$prop = $this->itemName2prop($element->getName());
			$getter = $this->composeGetterName($prop);

			if($element instanceof \Nette\Forms\Controls\SubmitButton){
				continue;
			}

			if(!$this->metaData->hasField($prop)){
				continue;
			}

			if(is_callable(array($entity,$getter))){

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
