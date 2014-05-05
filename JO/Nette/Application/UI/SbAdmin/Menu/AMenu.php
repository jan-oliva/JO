<?php

namespace JO\Nette\Application\UI\SbAdmin\Menu;

/**
 * Description of AMenu
 *
 * @author Jan Oliva
 */
abstract class AMenu extends \JO\Nette\Application\UI\AComponent implements IMenu
{
	protected $menuItems = array();

	/**
	 *
	 * @var  \Nette\Application\UI\Presenter
	 */
	protected $presenter;

	public function addItem(IMenuItem $item)
	{
		$this->menuItems[$item->getId()] = $item;
		return $this;
	}

	public function getItems()
	{
		return $this->menuItems;
	}

	public function isUserLoggedIn()
	{
		$presenter = $this->lookup('\Nette\Application\UI\Presenter');
		/* @var $presenter \Nette\Application\UI\Presenter */

		if($presenter instanceof \Nette\Application\UI\Presenter){
			return $presenter->getUser()->isLoggedIn();
		}
		return false;
	}

	
}
