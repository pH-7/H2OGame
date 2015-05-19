<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Language
{

    const COOKIE_NAME = 'H2OLang';

    private $_sLang;

    public function __construct()
    {
        $oCookie = new Cookie;
        $sMod = Application::getModule();

        if (Admin::auth() && is_file(H2O_SERVER_PATH . 'app/modules/' . $sMod . '/languages/' . Admin::getLang() . '.php') && is_file(H2O_SERVER_PATH . 'app/languages/' . Admin::getLang() . '.php'))
        {
            $oCookie->set(self::COOKIE_NAME, Admin::getLang(), 60*60*48);
            $this->_sLang = Admin::getLang();
        }
        elseif (!empty($_REQUEST['l']) && is_file(H2O_SERVER_PATH . 'app/modules/' . $sMod . '/languages/' . $_REQUEST['l'] . '.php') && is_file(H2O_SERVER_PATH . 'app/languages/' . $_REQUEST['l'] . '.php'))
        {
            $oCookie->set(self::COOKIE_NAME, $_REQUEST['l'], 60*60*48);
            $this->_sLang = $_REQUEST['l'];
        }
        elseif ($oCookie->exists(self::COOKIE_NAME) && is_file(H2O_SERVER_PATH . 'app/modules/' . $sMod . '/languages/' . $oCookie->get(self::COOKIE_NAME) . '.php') && is_file(H2O_SERVER_PATH . 'app/languages/' . $oCookie->get(self::COOKIE_NAME) . '.php'))
        {
            $this->_sLang = $oCookie->get(self::COOKIE_NAME);
        }
        elseif (is_file(H2O_SERVER_PATH . 'app/modules/' . $sMod . '/languages/' . $this->getBrowser() . '.php') && is_file(H2O_SERVER_PATH . 'app/languages/' . $this->getBrowser() . '.php'))
        {
            $this->_sLang = $this->getBrowser();
        }
        else
        {
            $this->_sLang = Controller::DEFAULT_LANG;
        }
        unset($oCookie);
    }

    /**
     * Get the language of the client browser.
     *
     * @return string First two letters of the languages ​​of the client browser.
     */
    public function getBrowser()
    {
        $sLang = explode(',',@$_SERVER['HTTP_ACCEPT_LANGUAGE']);
        return htmlspecialchars(strtolower(substr(chop($sLang[0]),0,2)), ENT_QUOTES);
    }

    public function get()
    {
        return $this->_sLang;
    }

}
