<?php

namespace JO\Security\Authenticator;

/**
 * Interface of apssword generator for authenticators
 * 
 * @author Jan Oliva
 */
interface IPasswordGenerator
{
	const PASSWORD_MAX_LENGTH = 4096;

	/**
	 * Creates salted password
	 * @param string $password
	 * @param string $salt
	 * @return string
	 */
	public function crypt($password,$salt);

}
