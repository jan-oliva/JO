<?php

namespace JO\Security\Authenticator;

/**
 *
 * @author Jan Oliva
 */
interface ICredentials
{
	public function getUsername();

	public function getPassword();
}
