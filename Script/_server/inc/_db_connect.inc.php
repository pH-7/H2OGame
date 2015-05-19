<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

$aParams = array
(
    'db_type' => Config::DB_TYPE,
    'db_host' => Config::DB_HOST,
    'db_name' => Config::DB_NAME,
    'db_usr' => Config::DB_USR,
    'db_pwd' => Config::DB_PWD,
    'db_charset' => Config::DB_CHARSET
);

Registry::getInstance()->oDb = new Db($aParams);
