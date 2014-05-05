<?php

namespace JO\Nette\Application\UI\SbAdmin\Menu;

/**
 *
 * @author Jan Oliva
 */
interface IMenuItem
{
	public function addChild(IMenuItem $child);

	public function getId();
	public function getClass();
	public function hasChildren();
	public function getChildern();
}
