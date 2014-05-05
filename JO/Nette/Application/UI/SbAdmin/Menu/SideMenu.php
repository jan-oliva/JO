<?php

namespace JO\Nette\Application\UI\SbAdmin\Menu;

/**
 * Description of SideMenu
 *
 * @author Jan Oliva
 */
class SideMenu extends AMenu implements IMenu
{
	protected function initTemplate()
	{
		$this->templatePath = dirname(__FILE__)."/sideMenu.latte";

		parent::initTemplate();
		
	}


	public function render()
	{
		$this->template->items = $this->getItems();
		$this->template->control = $this;
		return parent::render();
	}
}
