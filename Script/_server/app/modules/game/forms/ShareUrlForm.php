<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class ShareUrlForm
{

    /**
     * @param $sUrl The URL to share. If you enter nothing, it will be the current url. Default: NULL
     * @return void
     */
    public static function display($sUrl = null)
    {
        $sUrl = (!empty($sUrl)) ? $sUrl : current_url();

        $oForm = new \PFBC\Form('share_url_form');
        $oForm->configure(array('class' => 'center', 'view' => new \PFBC\View\Vertical));
        $oForm->addElement(new \PFBC\Element\Url('<span class="italic">' . trans('Share this Game') . '</span>', 'share', array('value'=>$sUrl, 'readonly'=>'readonly', 'onclick'=>'this.select()', 'style' => 'width:350px')));
        $oForm->render();
    }

}
