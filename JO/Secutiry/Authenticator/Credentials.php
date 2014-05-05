<?php

namespace JO\Security\Authenticator;

/**
 * Description of Credentials
 *
 * @author Jan Oliva
 */
class Credentials implements ICredentials
{

	protected $username;

	protected $password;

	/**
	 *
	 * @param string $username
	 * @param string $password
	 */
	function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

	public function getUsername()
	{
		return $this->username;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setUsername($username)
	{
		$this->username = $username;
		return $this;
	}

	public function setPassword($password)
	{
		$this->password = $password;
		return $this;
	}


}
