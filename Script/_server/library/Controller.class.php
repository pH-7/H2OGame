<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

abstract class Controller extends Application implements IController
{

    protected $oView, $oSession, $oHttpRequest, $sCurrentMod, $sCurrentLang, $sTitle;

    public function __construct ()
    {
        // Verify and correct the time zone if necessary
        if (!ini_get('date.timezone'))
            date_default_timezone_set(H2O_DEFAULT_TIMEZONE);

        $this->oSession = new Session; // PHP session initialization
        $this->oHttpRequest = new HttpRequest;
        $this->sCurrentMod = static::getModule();

        /*** Language initialization ***/
        $this->sCurrentLang = (new Language)->get(); // Check the client's language
        include_once H2O_SERVER_PATH . 'app/languages/' . $this->sCurrentLang . '.php';
        include_once H2O_SERVER_PATH . 'app/modules/' . $this->sCurrentMod . '/languages/' . $this->sCurrentLang . '.php';

        /*** Merge Core Language and module language file ***/
        $oRegistry = Registry::getInstance();
        $oRegistry->aLang += $oRegistry->aCoreLang;
        unset($oRegistry);

        /*** Template initialization ***/
        $this->oView = new Template;
        $this->oView->setTplDir(H2O_ROOT_PATH . 'themes/' . static::DEFAULT_THEME . '/tpl/');
        $this->oView->setCacheDir(H2O_SERVER_PATH  . 'data/caches/H2OTpl_cache');
        $this->oView->setCaching(false);

        $this->oView->sSiteName = Config::SITE_NAME;
        $this->oView->sSiteSlogan = Config::SITE_SLOGAN;
        $this->oView->sDescription = Config::SITE_DESCRIPTION;
        $this->oView->sKeywords = Config::SITE_KEYWORDS;
        $this->oView->sSoftName = static::SOFTWARE_NAME;
        $this->oView->sSoftVer = static::SOFTWARE_VERSION . ' Build ' . static::SOFTWARE_BUILD . ' - ' . static::SOFTWARE_VERSION_NAME;
        $this->oView->sSoftSite = static::SOFTWARE_WEBSITE;
        $this->oView->sSoftAuthor = static::SOFTWARE_AUTHOR;
        $this->oView->sSoftEmail = static::SOFTWARE_EMAIL;
        $this->oView->sTplName = static::DEFAULT_THEME;
        $this->oView->sCurrentLang = $this->sCurrentLang;
    }

    public function display()
    {
        $this->oView->display('layout');
    }

}
