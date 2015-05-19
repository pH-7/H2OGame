<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AdForm
{

    public static function display($oAd)
    {
        if (isset($_POST['submit_ad' . $oAd->adId]))
        {
            if (\PFBC\Form::isValid($_POST['submit_ad' . $oAd->adId]))
                new AdProcessForm($oAd->adId);

            redirect('?m=admin&a=ads');
        }

        $oForm = new \PFBC\Form('ad_form' . $oAd->adId);
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_ad' . $oAd->adId, 'ad_form' . $oAd->adId));
        $oForm->addElement(new \PFBC\Element\Hidden('id', $oAd->adId));
        $oForm->addElement(new \PFBC\Element\Textarea(trans('Ad Slot %0%:', $oAd->adId), 'code', array('value' => $oAd->code, 'style' => 'width:350px')));
        $oForm->addElement(new \PFBC\Element\Button(trans('Update')));
        $oForm->render();
    }

}