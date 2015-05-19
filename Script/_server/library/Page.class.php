<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2012-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          GNU General Public License
 * @version          1.2
 * @link             <http://software.hizup.com>
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Page
{

    private $_iTotalPages, $_iTotalItems, $_iNbItemsByPage, $_iCurrentPage, $_iFirstItem;

      /**
       * @static
       * @param float $iStartTime
       * @param float $iEndTime
       * @return float
       */
    public static function time($fStartTime, $fEndTime)
    {
        return round($fEndTime - $fStartTime, 8);
    }


    /***** Methods for preparing the paging system *****/

    /**
     * @access protected
     * @param integer $iTotalItems
     * @param integer $iNbItemsByPage
     * @return void
     */
    protected function totalPages($iTotalItems, $iNbItemsByPage)
    {
        $this->_iTotalItems = (int) $iTotalItems;
        $this->_iNbItemsByPage = (int) $iNbItemsByPage; // or intval() function, but it is slower than the cast
        $this->_iCurrentPage = (int) (!empty($_GET['p'])) ? $_GET['p'] : 1;
        $this->_iTotalPages = (int) ($this->_iTotalItems !== 0 && $this->_iNbItemsByPage !== 0) ? ceil($this->_iTotalItems / $this->_iNbItemsByPage) : 0; // Ternary condition to prevent division by zero
        $this->_iFirstItem = (int) ($this->_iCurrentPage-1) * $this->_iNbItemsByPage;
    }

    /**
     * @param integer $iTotalItems
     * @param integer $iNbItemsByPage Default 10
     * @return integer The number of pages.
     */
    public function getTotalPages($iTotalItems, $iNbItemsByPage = 10)
    {
        $this->totalPages($iTotalItems, $iNbItemsByPage);
        return ($this->_iTotalPages < 1) ? 1 : $this->_iTotalPages;
    }

    public function getTotalItems()
    {
        return $this->_iTotalItems;
    }

    public function getFirstItem()
    {
        return ($this->_iFirstItem < 0) ? 0 : $this->_iFirstItem;
    }

    public function getNbItemsByPage()
    {
        return $this->_iNbItemsByPage;
    }

    public function getCurrentPage()
    {
        return $this->_iCurrentPage;
    }

    /**
     * Clean a Dynamic URL for some features CMS.
     *
     * @static
     * @param string $sVar The Query URL (e.g. www.pierre-henry-soria.com/my-mod/?query=value).
     * @return string $sPageUrl The new clean URL.
     */
    public static function cleanDynamicUrl($sVar)
    {
        $sCurrentUrl = current_url();
        $sUrl = preg_replace('#\?.+$#', '', $sCurrentUrl);

        if (preg_match('#\?(.+[^\./])=(.+[^\./])$#', $sCurrentUrl))
        {
            $sUrlSlug = (strpos($sCurrentUrl, '&amp;')) ? strstr(strrchr($sCurrentUrl, '?'), '&amp;', true) : strrchr($sCurrentUrl, '?');
            $sPageUrl = $sUrl . Url::clean($sUrlSlug) . '&amp;' . $sVar . '=';
        }
        else
        {
            $sIsSlash = (substr($sUrl, -1) !== '/') ? '/' : '';
            $sPageUrl = $sUrl . $sIsSlash . '?' . $sVar . '=';
        }

        return $sPageUrl;
    }

    public function __destruct()
    {
        unset(
            $this->_iTotalPages,
            $this->_iTotalItems,
            $this->_iNbItemsByPage,
            $this->_iCurrentPage,
            $this->_iFirstItem
        );
    }

}
