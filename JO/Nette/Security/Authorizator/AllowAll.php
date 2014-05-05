<?php

namespace JO\Nette\Security\Authorizator;

/**
 * Description of AlowAll
 * Tests authorization interface. Allow all resources
 *
 * @author Jan Oliva
 */
class AllowAll implements \Nette\Security\IAuthorizator
{
	/**
	 *
	 * @param string $role
	 * @param string $resource
	 * @param string $privilege
	 * @return boolean
	 */
	public function isAllowed($role, $resource, $privilege)
	{
		\Nette\Diagnostics\Debugger::barDump(func_get_args(),__METHOD__. ' arguments');

		return true;
	}

}
