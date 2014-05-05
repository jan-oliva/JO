<?php

namespace JO\Nette\Application\UI\SbAdmin\Icons;

use Nette\Utils\Html;

/**
 * Description of Icon
 *
 * @author Jan Oliva
 */
class Icon
{
	const EDIT = 'fa fa-fw fa-edit';
	const USER = 'fa fa-fw fa-user';
	const BOOK = "fa fa-fw fa-book";
	const FIRE = "fa fa-fw fa-fire";
	const DELETE = "fa fa-fw fa-eraser";
	const GEAR = "fa fa-fw fa-gear";
	const FORLDER = "fa fa-fw fa-folder";
	const HOME = "fa fa-fw fa-home";
	const AMBULANCE = "fa fa-fw fa-ambulance";
	const BELL = "fa fa-fw fa-bell";
	const CALENDAR = "fa fa-fw fa-calendar";
	const SIGN_IN = "fa fa-fw fa-sign-in";
	const SIGN_OUT = "fa fa-fw fa-sign-out";
	const CUT = "fa fa-fw fa-cut";
	const COPY = "fa fa-fw fa-copy";
	const SAVE = "fa fa-fw fa-save";
	const MONEY = "fa fa-fw fa-money";
	const DASHBOARD = "fa fa-fw fa-dashboard";
	const TACHOMETER = "fa fa-fw fa-tachometer";


	/**
	 *
	 * @param string $type
	 * @return Html
	 */
	public static function createIcon($type)
	{
		return Html::el('i')->class($type);
	}
}
