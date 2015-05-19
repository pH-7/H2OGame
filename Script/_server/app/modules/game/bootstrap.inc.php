<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

// Check is the module is installed
$sFullSqlPath =  H2O_SERVER_PATH . 'app/addons/game/install/sql/' . Config::DB_TYPE_NAME . '/data_game.sql';
if (is_file($sFullSqlPath))
{
    if (!(new GameModel)->isGameInstalled())
    {
        require H2O_SERVER_PATH . 'inc/_db_connect.inc.php';
        exec_query_file(Registry::getInstance()->oDb, $sFullSqlPath,  Config::DB_TABLE_PREFIX);
    }
    else
    {
        @unlink($sFullSqlPath);
    }
}