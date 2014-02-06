<?php

namespace JO\Nette\Application\UI;

use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;
use Nette\DI\IContainer as IDIContainer;

/**
 * Description of FormBuilder
 *
 * @author Jan Oliva
 */
class FormFactory
{
	/**
	 *
	 * @var
	 */
	protected $context;

	/**
	 *
	 * @var Form
	 */
	protected $form;

	/**
	 *
	 * @param Nette\DI\IContainer $context
	 * @param Form $form - pokud neni predan je vytvoren
	 * @param IContainer $parent - ignorovano, pokud je predan form
	 * @param string $name - ignorovano, pokud je predan form
	 */
	function __construct(IDIContainer $context,Form $form=null,  IContainer $parent=null,$name=null)
	{
		$this->context = $context;
		if(!$form instanceof Form){
			$form = new Form($parent,$name);
		}
		$this->form = $form;
	}

	public function getForm()
	{
		return $this->form;
	}

}
