<?php

namespace JO\Nette\Application\UI\SbAdmin\Menu;

/**
 * Description of MenuItem
 *
 * @author Jan Oliva
 */
class MenuItem implements IMenuItem
{
	protected $id;

	protected $link;

	protected $label;

	protected $class;

	protected $childern = array();

	function __construct($id, $link, $label,$class)
	{
		$this->id = $id;
		$this->link = $link;
		$this->label = $label;
		$this->class = $class;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function getLink()
	{
		return $this->link;
	}

	public function getLabel()
	{
		return $this->label;
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 *
	 * @param MenuItem $child
	 * @return MenuItem
	 */
	public function addChild(\JO\Nette\Application\UI\SbAdmin\Menu\IMenuItem $child)
	{
		$this->childern[$child->getId()] = $child;
		return $this;
	}

	/**
	 *
	 * @return array
	 */
	public function getChildern()
	{
		return $this->childern;
	}

	public function hasChildren()
	{
		return !empty($this->childern);
	}
}
