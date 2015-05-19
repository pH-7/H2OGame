<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AnalyticsProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $aData = [
            'code' => $_POST['code'] // We don't use HttpRequest::post() because we need to allow HTML code for ad slots
        ];

        if ((new AdminModel)->exe($aData, 'update_analytics'))
        {
            // OK
            \PFBC\Form::clearValues('analytics_form');
            \PFBC\Form::setSuccess('analytics_form', trans('The Analytics code has been successfully updated'));
        }
        else
        {
            \PFBC\Form::setError('analytics_form', trans('Error occurred'));
        }

    }

}
