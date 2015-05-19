<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

/**
 * @final
 * @class Singleton Class
 */
final class Registry
{

    /**
     * @access private
     * @staticvar array $_aData The data array.
     */
    private static $_aData = array();

    /**
     * @staticvar object $_oInstance
     */
    private static $_oInstance = null;

    /**
     * Class constructor.
     * Marked as private so this constructor cannot be called from outside.
     *
     * @access private
     * @final
     */
    final private function __construct() {}

    /**
     * Get instance of class.
     *
     * @access public
     * @static
     * @return object Return the instance class or create intitial instance of the class.
     */
    public static function getInstance()
    {
        return (null === static::$_oInstance) ? static::$_oInstance = new static : static::$_oInstance;
    }

    /**
     * Get a data in the register.
     *
     * @param string $sName
     * @return string (string | null) If it finds a given, it returns the data, otherwise returns null.
     */
    public function __get($sName)
    {
        if (isset(self::$_aData[$sName]))
            return self::$_aData[$sName];

        return null;
    }

    /**
     * Set a data in the register.
     *
     * @param string $sName
     * @param string $sValue
     * @return void
     */
    public function __set($sName, $sValue)
    {
        self::$_aData[$sName] = $sValue;
    }

    /**
     * Block cloning.
     *
     * @access private
     * @final
     */
    final private function __clone() {}

}