<?php

namespace JO\Enum;

/**
 * Abstraktní třída pro implementaci dynamického výčtového typu.
 *
 * Hodnoty výčtu jsou nasetovány za běhu.
 * <pre>
 * class LogoutReasonsEnum extends DynamicEnum {
 *
 * }
 *
 * LogoutReasonsEnum::init(array(
 *      '__default' => 2,
 *      'LOGOUT_REASON_MANUAL' => 1,
 *      'LOGOUT_REASON_INACTIVITY' => 2
 *      'LOGOUT_REASON_BROWSER_CLOSED' => 4
 *  ));
 * </pre>
 */
abstract class DynamicEnum extends Enum
{

	/**
	 * Data výčtu.
	 *
	 * @var array
	 */
	protected static $cache = array();

	/**
	 * Inicializace dat výčtu.
	 *
	 * @param array $data Data
	 */
	public static function init(array $data)
	{
		$class = \get_called_class();
		if (!isset(self::$cache[$class])) {
			self::$cache[$class] = array(
				'__default' => null
			);
		}
		self::$cache[$class] = array_merge(self::$cache[$class], $data);
	}

	/**
	 * Vrátí pole definovaných dat výčtu.
	 *
	 * @param boolean $includeDefault Včetně výchozí hodnoty?
	 * @return array
	 */
	public static function getConstList($includeDefault = false)
	{
		$class = \get_called_class();
		$constants = self::$cache[$class];
		if (!$includeDefault) {
			unset($constants['__default']);
		}
		return $constants;
	}

	/**
	 * Vrátí výchozí hodnotu.
	 *
	 * @return mixed
	 */
	protected static function getDefault()
	{
		$class = \get_called_class();
		return static::$cache[$class]['__default'];
	}


}
