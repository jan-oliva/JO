<?php

namespace JO\Enum;

/**
 * Abstraktní třída reprezentující výčet.
 */
abstract class Enum implements IEnum
{

    /**
     * Pole s instancemi objektů reprezentujích hodnotu výčtu pro každý typ výčtu.
     *
     * @var array
     */
    private static $instances = array();

    /**
     * Název hodnoty výčtu.
     *
     * @var string
     */
    private $name;

    /**
     * Hodnota výčtu.
     *
     * @var mixed
     */
    private $value;

    /**
     * Šablona chybové zprávy.
     *
     * Využívá %name% (požadovaná položka výčtu) a %list% (seznam všech možných hodnot výčtu).
     *
     * @var string
     */
    protected static $defaultErrorMessage = 'Unknown element "%name%" available are [%list%].';

    /**
     * Vytvoření objektu ze definovaného výčtu.
     *
     * @param mixed $value Hodnota výčtu
     * @throws \UnexpectedValueException Pokud hodnota není ve výčtu
     */
    final private function __construct($value)
    {
        $constants = static::getConstList();
        if (($name = array_search($value, $constants, true)) === false) {
            throw new \UnexpectedValueException($this->getErrorMessage($value, $constants));
        }

        $this->name = $name;
        $this->value = $value;
    }


    /**
     * Vrátí název hodnoty výčtu.
     *
     * @return string
     */
    final public function getName()
    {
        return $this->name;
    }

    /**
     * Vrátí hodnotu výčtu.
     *
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * Vrátí vyplněnou chybovou zprávu.
     *
     * @param mixed $value Hodnota
     * @param array $constants Pole možných hodnot výčtu
     * @return string
     */
    protected function getErrorMessage($value, $constants)
    {
        return \str_replace(
                array('%name%', '%list%'), array(var_export($value, true),
                var_export($constants, true)), static::$defaultErrorMessage
        );
    }

    /**
     * Vytvoří, nacachuje a vrátí objekt.
     *
     * @param mixed $value Hodnota nebo null pro výchozí
     * @return self
     */
    final public static function create($value = null)
    {
        if ($value === null) {
            $value = static::getDefault();
        }

        $class = \get_called_class();
        $serValue = \serialize($value);
        if (!isset(self::$instances[$class][$serValue])) {
            self::$instances[$class][$serValue] = new static($value);
        }

        return self::$instances[$class][$serValue];
    }

    /**
     * Vrátí hodnotu v textové podobě.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getValue();
    }

}
