<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class Main
{

    /**
     * Get Languages List.
     *
     * @return array The list.
     */
    public static function getLangList()
    {
        $sPathLang = H2O_SERVER_PATH . 'app' . H2O_DS . 'modules' . H2O_DS . Application::getModule() . H2O_DS . 'languages' . H2O_DS;
        $aLangFiles = (new File)->getFileList($sPathLang);
        $aLangsList = include(H2O_SERVER_PATH . 'inc/lang_list.inc.php');

        $aLangs = array();
        foreach ($aLangFiles as $sFileName)
        {
            $sFileName = str_replace(array($sPathLang, '.php'), '', $sFileName);
            $aLangs[$sFileName] = $aLangsList[$sFileName];
        }

        return $aLangs;
    }

}