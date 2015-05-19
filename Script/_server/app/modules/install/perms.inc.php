<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

$sCtrlName = Application::getControllerName();
$sAct = Application::getAction();

if ((Application::isInstalled()) && $sCtrlName == 'Main' && $sAct == 'index')
    exit('Your site is already installed.<br />If you want to redo a clean install, please clear the value of the constant DB_NAME in "Config.class.php" file and delete all the content of your database.');