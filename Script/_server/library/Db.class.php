<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Db extends \PDO
{

    const RAND = 'RAND()';

    public function __construct(array $aParams)
    {
        $aDriverOptions[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES ' . $aParams['db_charset'];
        parent::__construct("{$aParams['db_type']}:host={$aParams['db_host']};dbname={$aParams['db_name']};", $aParams['db_usr'], $aParams['db_pwd'], $aDriverOptions);
        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * If table name is empty, only prefix will be returned otherwise the table name with its prefix will be returned.
     *
     * @param string $sTable Table name.
     * @param boolean $bTrim With or without a space before and after the table name. Default valut is "false", so with space before and after table name.
     * @return string prefixed table name, just prefix if table name is empty.
     */
    public static function prefix($sTable = '', $bTrim = false)
    {
        $sSpace = (!$bTrim) ? ' ' : '';
        return ($sTable !== '') ? $sSpace . Config::DB_TABLE_PREFIX . $sTable . $sSpace : Config::DB_TABLE_PREFIX;
    }

}