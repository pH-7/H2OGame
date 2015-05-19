<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AdProcessForm extends Controller
{

    public function __construct($iAdId)
    {
        parent::__construct();

        $aData = [
            'ad_id' => (int) $this->oHttpRequest->post('id'),
            'code' => $_POST['code'] // We don't use HttpRequest::post() because we need to allow HTML code for ad slots
        ];

        if ((new AdminModel)->exe($aData, 'update_ad'))
        {
            // OK
            \PFBC\Form::clearValues('ad_form' . $iAdId);
            \PFBC\Form::setSuccess('ad_form' . $iAdId, trans('The ad has been successfully updated'));
        }
        else
        {
            \PFBC\Form::setError('ad_form' . $iAdId, trans('Error occurred'));
        }

    }

}