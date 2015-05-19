<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class ShareEmbedForm
{

    /**
     * Embed code
     *
     * @param string $sGameUrl
     * @param integer $iEmbedWidth Width of the embed code. Default: 580
     * @param integer $iEmbedHeight Height of the embed code. Default: 450
     * @return void
     */
    public static function display($sGameUrl, $iEmbedWidth = 580, $iEmbedHeight = 450)
    {
        $sEmbedCode = '<object codebase="http://www.adobe.com/go/getflashplayer" width="' . $iEmbedWidth . '" height="' . $iEmbedHeight . '" align="middle"><param name="movie" value="' . $sGameUrl . '" /><param name="quality" value="high" /><embed src="'. $sGameUrl . '" width="' . $iEmbedWidth . '" height="' . $iEmbedHeight . '" align="middle" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed></object>';

        $oForm = new \PFBC\Form('share_embed_form');
        $oForm->configure(array('class' => 'center', 'view' => new \PFBC\View\Vertical));
        $oForm->addElement(new \PFBC\Element\Textarea('<span class="italic">' . trans('Embed Code') . '</span>', 'embed', array('value'=>$sEmbedCode, 'readonly'=>'readonly', 'onclick'=>'this.select()', 'style' => 'width:350px')));
        $oForm->render();
    }

}
