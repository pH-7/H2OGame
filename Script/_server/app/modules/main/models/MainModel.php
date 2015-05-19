<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class MainModel extends Model
{

    private $_sQueryPath;

    public function __construct()
    {
        parent::__construct();
        $this->_sQueryPath = __DIR__ . H2O_DS . 'queries/';
    }

    public function getAd($iId)
    {
        $iId = (int) $iId;

        $rStmt = $this->oDb->prepare( $this->getQuery('get_ad', $this->_sQueryPath) );
        $rStmt->bindValue(':ad_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return (!empty($oRow->code)) ? $oRow->code : '';
    }

    public function getAds()
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_ads', $this->_sQueryPath) );
        $rStmt->execute();
        return $rStmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getAnalytics()
    {
        $rStmt = $this->oDb->prepare( $this->getQuery('get_analytics', $this->_sQueryPath) );
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return (!empty($oRow->code)) ? $oRow->code : '';
    }

    public function getAdminLang($iId)
    {
        $iId = (int) $iId;

        $rStmt = $this->oDb->prepare( $this->getQuery('get_admin_lang', $this->_sQueryPath) );
        $rStmt->bindValue(':profile_id', $iId, \PDO::PARAM_INT);
        $rStmt->execute();
        $oRow = $rStmt->fetch(\PDO::FETCH_OBJ);
        return @$oRow->lang;
    }

}
