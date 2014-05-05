<?php

namespace JO\Nette\Application\UI\Login;

use JO\Nette\Application\UI\FormBootstrapRenderer;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\Button;
use Nette\Security\IAuthenticator;

/**
 * Description of Login
 *
 * @author Jan Oliva
 */
class Login extends \JO\Nette\Application\UI\AComponent
{
	const F_PASSWORD = 'F_PASSWORD';
	const F_LOGIN = 'F_LOGIN';
	const F_REMEMBER = 'F_REMEBER';

	//submit login
	const S_LOGIN = 'S_LOGIN';

	public $onLoginFilure = array();

	protected $title = 'login';
	protected $loginLabel = 'login';
	protected $passwordLabel = 'password';
	protected $rememberMeLabel = 'remember Me';
	protected $buttonLabel = 'login';


	/**
	 *
	 * @var \Nette\Security\User
	 */
	protected $user;

	function __construct(\Nette\Security\User $user,$translator, $parent, $name)
	{
		parent::__construct($translator, $parent, $name);
		$this->user = $user;

	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function setLoginLabel($loginLabel)
	{
		$this->loginLabel = $loginLabel;
		return $this;
	}

	public function setPasswordLabel($passwordLabel)
	{
		$this->passwordLabel = $passwordLabel;
		return $this;
	}

	public function setRememberMeLabel($rememberMeLabel)
	{
		$this->rememberMeLabel = $rememberMeLabel;
		return $this;
	}

	public function setButtonLabel($buttonLabel)
	{
		$this->buttonLabel = $buttonLabel;
		return $this;
	}


	protected function initTemplate()
	{
		$this->templatePath = dirname(__FILE__)."/login.latte";

		parent::initTemplate();

	}

	public function render()
	{
		$this->template->title = $this->title;
		$this->template->control = $this;
		return parent::render();
	}


	public function login(Button $button)
	{
		$values = $button->getForm()->getValues();
		try{
			$this->user->login($values[self::F_LOGIN], $values[self::F_PASSWORD]);
			$this->user->setExpiration("60 minutes",true);
		}  catch (\Nette\Security\AuthenticationException $e){
			$this->onLoginFilure();
		}
	}

	protected function createComponentLoginForm($name)
	{
		$form = new Form($this,$name);
		$form->getElementPrototype()->role = 'form';
		$form->setRenderer(new FormBootstrapRenderer());

		$form->addText(self::F_LOGIN)
				->setRequired("vyplňte přihlašovací jméno")
				->setAttribute('placeholder', $this->loginLabel)
				->setAttribute("autofocus","autofocus")
				->setAttribute("size","60");

		$form->addPassword(self::F_PASSWORD)
				->setRequired('Vyplňte heslo')
				->setAttribute('placeholder', $this->passwordLabel)
				->setAttribute("size","60");


		$form->addCheckbox(self::F_REMEMBER,$this->rememberMeLabel);

		$submit = $form->addSubmit(self::S_LOGIN, $this->buttonLabel);
		$submit->getControlPrototype()->class[] = 'btn-sucess';
		$submit->getControlPrototype()->class[] = 'btn-block';
		$submit->getControlPrototype()->class[] = 'btn-lg';

		$submit->onClick[] = callback($this,'login');
	}
}
