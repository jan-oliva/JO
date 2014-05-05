<?php

namespace JO\Nette\Application\UI;

use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;

/**
 * Description of Acomponent
 *
 * Abstraktni trida pro komponenty s prekladacem.
 *
 * @author Jan Oliva
 */
abstract class AComponent extends Control
{

	/** @var string */
	protected $templatePath;

	/**
	 *
	 * @var ITranslator
	 */
	protected $translator;

	/**
	 * Potomek by mel zarucit nastaveni vlastnosti AComponent::templatePath
	 * @param \Nette\Localization\ITranslator $translator
	 */
	function __construct(ITranslator $translator, $parent = null, $name = null)
	{
		$this->translator = $translator;
		parent::__construct($parent, $name);
		$this->initTemplate();
	}

	/**
	 * Nstaveni cesty sblone
	 * @param type $templatePath
	 * @return \AComponent
	 */
	protected function setTemplatePath($templatePath)
	{
		$this->templatePath = $templatePath;
		return $this;
	}

	/**
	 * inicilalizace sablony
	 */
	protected function initTemplate()
	{
		if (is_null($this->templatePath)) {
			throw new \RuntimeException("AComponent::\$templatePath is not set. Use AComponent::setTemplatePath() method in child.");
		}
		$this->template->setFile($this->templatePath);
		$this->template->setTranslator($this->translator);
	}

	/**
	 * V potomcich se masi bude pretezovat
	 * @return string
	 */
	public function render()
	{
		return $this->template->render();
	}

}
