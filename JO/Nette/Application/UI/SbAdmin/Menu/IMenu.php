<?php

namespace JO\Nette\Application\UI\SbAdmin\Menu;

/**
 *
 * @author Jan Oliva
 */
interface IMenu
{
	public function addItem(IMenuItem $item);

	/**
	 * @return array - item is IMenuItem
	 */
	public function getItems();
}
