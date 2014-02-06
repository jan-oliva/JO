<?php

namespace JO\Nette\Application\UI;

use Nette\Forms\Form;
use Nette\Forms\Rendering\DefaultFormRenderer;


/**
 * Description of FormBootstrapRenderer
 *
 * @author Jan Oliva
 */
class FormBootstrapRenderer extends DefaultFormRenderer
{
	public function render(Form $form, $mode = NULL)
	{
		if ($this->form !== $form) {
			$this->form = $form;
			$this->init();
		}

		foreach ($this->form->getControls() as $control) {
			/* @var $control \Nette\Forms\Controls\TextInput */

			$el = $control->getControlPrototype();
			/* @var $el \Nette\Utils\Html */
			if($control instanceof \Nette\Forms\Controls\TextInput || $control instanceof \Nette\Forms\Controls\SelectBox){
				$control->setAttribute('class', 'form-control');
			}elseif($control instanceof \Nette\Forms\Controls\Button){
				$control->setAttribute('class', 'btn btn-default');
			}

			//btn btn-default
		}
		$ret = parent::render($form, $mode);
		return $ret;
	}
}
