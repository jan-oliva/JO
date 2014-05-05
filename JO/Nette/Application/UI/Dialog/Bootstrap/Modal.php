<?php

namespace JO\Nette\Application\UI\Dialog\Bootstrap;

/**
 * Description of ModalBootstrap
 *
 * Examle
 *
 * ** template ****
 *
 *  <a data-toggle="modal"  data-target="#jobModal" id="modalShow" href="#">show modal</a>
 *	{control usersDialog}
 * *********************
 *
 * ** Controller  ***
 *	public function createComponentUsersDialog($name)
 *	{
 *		$control = new \JO\Nette\Application\UI\Dialog\Bootstrap\Modal($this->context->getService('ITranslator'),$this, $name);
 *		$control->setTitle('neco se stalo')
 * 				->setContent('ahojda')
 *				->setId('jobModal');
 *		return $control;
 *	}
 * ********************************
 *
 * @author Jan Oliva
 */
class Modal extends \JO\Nette\Application\UI\AComponent
{
	protected $id;

	protected $title;

	protected $buttonLabel;

	protected $buttonID;

	protected $content;


	protected function initTemplate()
	{
		$this->templatePath = dirname(__FILE__)."/modal.latte";

		parent::initTemplate();
	}

	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

		public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function setButtonLabel($buttonLabel)
	{
		$this->buttonLabel = $buttonLabel;
		return $this;
	}

	/**
	 * set html id
	 * @param type $buttonID
	 * @return \JO\Nette\Application\UI\Dialog\Bootstrap\Modal
	 */
	public function setButtonID($buttonID)
	{
		$this->buttonID = $buttonID;
		return $this;
	}


	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}


	public function render()
	{
		$unique = uniqid();
		$this->template->id = (isset($this->id)) ? $this->id : "modal_{$this->name}_{$unique}_";
		$this->template->title = $this->title;
		$this->template->content = $this->content;
		$this->template->buttonID = (isset($this->buttonID)) ? $this->buttonID : "modal_btn_ok_{$this->name}";
		$this->template->buttonLabel = isset($this->buttonLabel) ? $this->buttonLabel : "OK";
		$this->template->render();
	}
}
