<?php

namespace JO\Nette\Application\UI\Tabs;

/**
 * Description of Tabs
 * Render twiter bootstrap tabs.
 *
 * @author Jan Oliva
 */
class Tabs extends \JO\Nette\Application\UI\AComponent
{
	protected $id;

	protected $tabs = array();

	protected $mainDivClasess = array();

	protected $mainelementClass;

	/**
	 *
	 * @var string
	 */
	protected $activeTab ;



	protected function initTemplate()
	{
		$this->templatePath = dirname(__FILE__)."/tabs.latte";

		parent::initTemplate();
	}

	public function setMainElementClass($mainElementClass)
	{
		$this->mainelementClass = $mainElementClass;
		return $this;
	}


	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 *
	 * @param string $name
	 * @param string|array $link - example "list" | array('edit','id'=>5)
	 * @param string $label
	 * @param bool $enabled
	 * @return \JO\Nette\Application\UI\Tabs\Tabs
	 */
	public function addTab($name,$link,$label,$enabled=true)
	{
		$l = new \stdClass();
		if(is_array($link)){
			$l->href = array_shift($link);
			$l->hrefArgs =  $link;
			\Nette\Diagnostics\Debugger::barDump($l, 'link', array(\Nette\Diagnostics\Dumper::DEPTH => 5));
		}else{
			$l->href = $link;
			$l->hrefArgs = array();
		}

		$l->label = $label;
		$l->isEnabled = $enabled;
		$this->tabs[$name] = $l;
		return $this;
	}

	public function setActiveTab($name)
	{
		if($this->tabExixsts($name)){
			$this->activeTab = $name;
		}
	}

	public function disableTab($tab)
	{
		if($this->tabExixsts($tab)){
			$this->tabs[$tab]->isEnabled = false;
		}
	}

	public function enableTab($tab)
	{
		if($this->tabExixsts($tab)){
			$this->tabs[$tab]->isEnabled = false;
		}
	}

	private function tabExixsts($name)
	{
		return isset($this->tabs[$name]);
	}


	/**
	 *
	 */
	public function render()
	{
		$this->template->id = $this->id;
		$this->template->mainelementClass = $this->mainelementClass;
		$this->template->tabs = $this->tabs;
		$this->template->activeTab = $this->activeTab;
		$this->template->render();
	}
}
