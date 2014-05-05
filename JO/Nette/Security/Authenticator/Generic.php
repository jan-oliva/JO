<?php

namespace JO\Nette\Security\Authenticator;

use JO\Security\Authenticator\Credentials;
use Nette\Security\IAuthenticator;

/**
 * Description of Generic
 *
 * It is iterface for using nette IAuthnticator::authenticate with JO\Security\Authenticator\ICredentials
 * Using given authenticator model. Use ICredetials for login.
 *
 * @author Jan Oliva
 */
class Generic extends AAuthenticator implements IAuthenticator
{
	/**
	 * Call athenticate on given model.
	 * @param array $credentials
	 * @return \Nette\Security\IIdentity
	 */
	public function authenticate(array $credentials)
	{
		list($username, $password) = $credentials;
		return $this->model->authenticate(new Credentials($username, $password));
	}

}
