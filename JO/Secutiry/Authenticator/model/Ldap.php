<?php

namespace JO\Security\Authenticator\model;

use JO\Security\Authenticator\ICredentials;
use JO\Security\Authenticator\IPasswordGenerator;
use Nette\Diagnostics\Debugger;

/**
 * Description of Ldap
 * Authenticate user oposite LDAP server
 *
 * @author Jan Oliva
 * @todo dodelat ldap overeni	
 */
class Ldap implements IModel
{
	public function authenticate(ICredentials $credentials)
	{
		Debugger::barDump($credentials);
	}

	public function setPasswordGenerator(IPasswordGenerator $passwordGenerator)
	{

	}

}
