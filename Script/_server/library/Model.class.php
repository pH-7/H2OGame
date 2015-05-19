<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

require H2O_SERVER_PATH . 'inc/_db_connect.inc.php';

class Model
{

    const SQL_FILE_EXT = '.sql';

    protected $oDb;
    private $_sContents;

    public function __construct()
    {
        $this->oDb = Registry::getInstance()->oDb;
    }

    /**
     * Get SQL query file.
     *
     * @param string $sFile SQL file name.
     * @param string $sPath Path to SQL file.
     * @return string The SQL query.
     */
    public function getQuery($sFile, $sPath)
    {
        $sFullPath = $sPath . $sFile . static::SQL_FILE_EXT;
        $this->_sContents = file_get_contents($sFullPath);
        $this->_parseVar();

        return $this->_sContents;
    }

    /**
     * @param string $sFile SQL file name.
     * @param string $sPath Path to SQL file.
     * @param array $aParams Default NULL
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function exec($sFile, $sPath, array $aParams = null)
    {
        $rStmt = $this->oDb->prepare( $this->getQuery($sFile, $sPath) );
        $bRet = $rStmt->execute($aParams);

        return $bRet;
    }

    /**
     * Parse query variables.
     *
     * @return void
     */
    private function _parseVar()
    {
        $this->_sContents = str_replace('[DB_PREFIX]', Config::DB_TABLE_PREFIX, $this->_sContents);
    }

}