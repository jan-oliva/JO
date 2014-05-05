<?php

namespace JO\Security\Authenticator;

/**
 * Description of PasswordGenerator
 *
 * Password generator for IAuthlenticator.
 * Use hash_hmac, sha512.
 *
 * @author Jan Oliva
 */
class PasswordGenerator implements IPasswordGenerator
{
	/**
	 *
	 * @param string $password
	 * @param string $salt
	 */
	public function crypt($password, $salt)
	{
		$password = substr($password, 0, self::PASSWORD_MAX_LENGTH);
		return hash_hmac("sha512", $password, $salt);
	}

}
