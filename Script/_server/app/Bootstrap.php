<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

/*** We define the URL if overwrite mode is enabled (to enable it. Htaccess must be present in the current directory) ***/
define( 'H2O_URL_SLUG', H2O_ROOT_URL . (!is_url_rewrite() ? '?a=' : '') );

$sNP = 'H2O\\';
$sCoreMod = 'main';
$sCoreCtrlName = 'core';
$sMod = Application::getModule();
$sCtrl = Application::getController();
$sAct = Application::getAction();

if (!Application::isInstalled() && $sMod !== 'install')
    redirect('?m=install'); // First usage, let's go to the installer!

try
{
    require H2O_SERVER_PATH . '/inc/mod_loader.inc.php';

    $sFullModPath = H2O_SERVER_PATH . 'app/modules/' . $sMod . '/';
    if (is_file($sFullModPath . 'controllers/' . $sCtrl . '.php'))
    {
        $sCtrl = $sNP . $sCtrl;
        $oCtrl = new $sCtrl;

        if (method_exists($oCtrl, $sAct))
        {
            if (is_file($sFullModPath . 'perms.inc.php'))
                require $sFullModPath . 'perms.inc.php';

            if (is_file($sFullModPath . 'bootstrap.inc.php'))
                require $sFullModPath . 'bootstrap.inc.php';

            call_user_func(array($oCtrl, $sAct));
        }
        else
        {
            Application::setModule($sCoreMod); // Set the Core module
            Application::setController($sCoreCtrlName); // Set the Core controller
            Application::setAction('error404'); // Set the "Not Found page" action
            $sCoreCtrl = $sNP . Application::getController();
            (new $sCoreCtrl)->error404();
        }
    }
    else
    {
        Application::setModule($sCoreMod); // Set the Core module
        Application::setController($sCoreCtrlName); // Set the Core controller
        Application::setAction('error404'); // Set the "Not Found page" action
        $sCoreCtrl = $sNP . Application::getController();
        (new $sCoreCtrl)->error404();
    }
}
catch (\Exception $oE)
{
    echo '<p><b>Exception launched!</b><br /><br />' .
    'Message: ' . $oE->getMessage() . '<br />' .
    'File: ' . $oE->getFile() . '<br />' .
    'Line: ' . $oE->getLine() . '<br />' .
    'Trace: <p/><pre>' . $oE->getTraceAsString() . '</pre>';
}
