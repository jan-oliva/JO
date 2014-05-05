<?php

namespace JO\Enum;

/**
 * Abstraktní třída pro implementaci výčtového typu.
 *
 * Hodnoty musejí být implementovány pomocí třídních konstant.
 * <pre>
 * class LogoutReasonsEnum extends StaticEnum {
 *
 *     const
 *         __default = self::LOGOUT_REASON_INACTIVITY,
 *         LOGOUT_REASON_MANUAL = 1,
 *         LOGOUT_REASON_INACTIVITY = 2,
 *         LOGOUT_REASON_BROWSER_CLOSED = 4;
 *
 * }
 * </pre>
 */
abstract class StaticEnum extends Enum
{
    /**
     * Výchozí hodnota.
     *
     * @var mixed
     */

    const __default = null;

    /**
     * Pole definovaných třídních konstant.
     *
     * @var array
     */
    protected static $constants = array();

    /**
     * Vrátí pole definovaných třídních konstant.
     *
     * @param boolean $includeDefault Včetně výchozí hodnoty?
     * @return array
     */
    public static function getConstList($includeDefault = false)
    {
        $class = \get_called_class();
        if (!isset(self::$constants[$class])) {
            $reflector = new \ReflectionClass($class);
            $constants = $reflector->getConstants();
            if (!$includeDefault) {
                unset($constants['__default']);
            }
            self::$constants[$class] = $constants;
        }

        return self::$constants[$class];
    }

    /**
     * Vrátí výchozí hodnotu.
     *
     * @return mixed
     */
    protected static function getDefault()
    {
        return static::__default;
    }

}
