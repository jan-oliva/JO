<?php

namespace JO\Enum;

/**
 * Rozhraní pro výčet.
 */
interface IEnum
{

    /**
     * Vrátí jméno hodnoty.
     */
    public function getName();

    /**
     * Vrátí hodnotu.
     */
    public function getValue();

    /**
     * Vrátí pole definovaných názvů a hodnot výčtu.
     */
    public static function getConstList();

}
