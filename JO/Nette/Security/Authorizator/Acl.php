<?php

namespace JO\Nette\Security\Authorizator;

/**
 * Description of Acl
 *
 * ACL authorizator
 * 
 * @author Jan Oliva
 *
 * @todo - make content of class
 */
class Acl implements \Nette\Security\IAuthorizator
{

	/**
	 *
	 * @param type $role
	 * @param type $resource
	 * @param type $privilege
	 * @return boolean
	 */
	public function isAllowed($role, $resource, $privilege)
	{
		return false;
	}

}
