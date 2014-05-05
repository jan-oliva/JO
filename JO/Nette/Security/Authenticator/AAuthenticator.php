<?php

namespace JO\Nette\Security\Authenticator;

use JO\Security\Authenticator\IPasswordGenerator;
use JO\Security\Authenticator\model\IModel;

/**
 * Description of AAuthenticator
 *
 * @author Jan Oliva
 */
abstract class AAuthenticator
{
	/**
	 *
	 * @var IPasswordGenerator
	 */
	protected $passwordGenerator;

	/**
	 *
	 * @var IModel - model for authentication
	 */
	protected $model;

	/**
	 *
	 * @param \JO\Security\Authenticator\IPasswordGenerator $passwordGenerator
	 * @param \JO\Security\Authenticator\model\IModel $model
	 */
	function __construct(IPasswordGenerator $passwordGenerator, IModel $model)
	{
		$this->passwordGenerator = $passwordGenerator;
		$this->model = $model;
		$this->model->setPasswordGenerator($passwordGenerator);
	}

}
