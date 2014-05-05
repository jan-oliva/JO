<?php

namespace JO\Security\Authenticator\Factory;
/**
 * Description of Ldap
 *
 * @author Jan Oliva
 * @todo doresit zaislosti tere potrebuje LDAP autetizace
 */
class Ldap
{
	public static function createInstance()
	{
		$obj = new \JO\Security\Authenticator\model\Ldap();
		return $obj;
	}
}
