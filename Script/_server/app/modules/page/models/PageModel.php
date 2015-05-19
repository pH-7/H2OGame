<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class PageModel extends Model
{

    private $_sQueryPath;

    public function __construct()
    {
        parent::__construct();
        $this->_sQueryPath = __DIR__ . H2O_DS . 'queries/';
    }

    public function exe(array $aParams, $sSqlName)
    {
        return $this->exec($sSqlName, $this->_sQueryPath, $aParams);
    }

    public function get($iId)
    {
        $iId = (int) $iId;

        $rStmt = $this->oDb->prepare( $this->getQuery('get_page', $this->_sQueryPath) );
        $rStmt->bindValue(':page_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        return $rStmt->fetch(\PDO::FETCH_OBJ);
    }

    public function gets()
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_pages', $this->_sQueryPath) );
        $rStmt->execute();
        return $rStmt->fetchAll(\PDO::FETCH_OBJ);
    }

}