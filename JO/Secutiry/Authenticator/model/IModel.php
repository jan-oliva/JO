<?php

namespace JO\Security\Authenticator\model;

use JO\Security\Authenticator\ICredentials;
use JO\Security\Authenticator\IPasswordGenerator;

/**
 *
 * @author Jan Oliva
 */
interface IModel
{
	public function authenticate(ICredentials $credentials);

	public function setPasswordGenerator(IPasswordGenerator $passwordGenerator);
}
