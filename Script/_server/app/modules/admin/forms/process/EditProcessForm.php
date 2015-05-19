<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class EditProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $aData = [
            'profile_id' => $this->oSession->get('admin_id'),
            'email' => $this->oHttpRequest->post('email'),
            'name' => $this->oHttpRequest->post('name'),
            'lang' => $this->oHttpRequest->post('lang')
        ];

        if ((new AdminModel)->exe($aData, 'update_profile'))
        {
            // OK
            \PFBC\Form::clearValues('edit_form');
            \PFBC\Form::setSuccess('edit_form', trans('Your profile has been successfully updated'));
        }
        else
        {
            \PFBC\Form::setError('edit_form', trans('Error occurred'));
        }
    }

}

