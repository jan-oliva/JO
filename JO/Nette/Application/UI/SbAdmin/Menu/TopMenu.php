<?php

namespace JO\Nette\Application\UI\SbAdmin\Menu;

/**
 * Description of TopMenu
 *
 * @author Jan Oliva
 */
class TopMenu extends AMenu
{
	protected function initTemplate()
	{
		$this->templatePath = dirname(__FILE__)."/topMenu.latte";

		parent::initTemplate();

	}


	public function render()
	{
		$this->template->items = $this->getItems();
		$this->template->control = $this;
		return parent::render();
	}
}
