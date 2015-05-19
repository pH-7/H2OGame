<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class LangForm
{

    public static function display($sCurrentLang)
    {
        $aLangs = array();
        foreach (Main::getLangList() as $sKey => $sVal)
            $aLangs['?l='.$sKey] = $sVal;

        $oForm = new \PFBC\Form('lang_form');
        $oForm->addElement(new \PFBC\Element\Select('', 'l', $aLangs, array('value' => $sCurrentLang, 'onchange' => 'document.location.href=this.value')));
        $oForm->render();
    }

}