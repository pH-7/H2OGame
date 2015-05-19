<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

abstract class Application
{
    const
    SOFTWARE_NAME = 'H2OGame',
    SOFTWARE_WEBSITE = 'http://hizup.com',
    SOFTWARE_EMAIL = 'ph7software@gmail.com',
    SOFTWARE_AUTHOR = 'Pierre-Henry Soria',
    SOFTWARE_LICENSE = 'See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.',
    SOFTWARE_COPYRIGHT = '© (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.',
    SOFTWARE_VERSION_NAME = 'H2O',
    SOFTWARE_VERSION = '1.0',
    SOFTWARE_BUILD = '1',
    CTRL_NAME = 'Controller',
    DEFAULT_MOD = 'game',
    DEFAULT_CTRL = 'main',
    DEFAULT_ACTION = 'index',
    DEFAULT_LANG = 'en',
    DEFAULT_THEME = 'classic';

    public static function isInstalled()
    {
        return (Config::DB_NAME != '');
    }

    public static function getModule()
    {
        return (!empty($_GET['m'])) ? $_GET['m'] : static::DEFAULT_MOD;
    }

    public static function getControllerName()
    {
        return str_replace(static::CTRL_NAME, '', static::getController());
    }

    public static function getController()
    {
        return ucfirst((!empty($_GET['c']) ? $_GET['c'] : static::DEFAULT_CTRL)) . static::CTRL_NAME;
    }

    public static function getAction()
    {
        return (!empty($_GET['a'])) ? strtolower($_GET['a']) : static::DEFAULT_ACTION;
    }

    public static function setModule($sModName)
    {
        $_GET['m'] = $sModName;
    }

    public static function setController($sCtrlName)
    {
        $_GET['c'] = $sCtrlName;
    }

    public static function setAction($sActName)
    {
        $_GET['a'] = $sActName;
    }

}