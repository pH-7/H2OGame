<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class AddAccountProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!validate_identical($this->oHttpRequest->post('password1'), $this->oHttpRequest->post('password2')))
        {
            \PFBC\Form::setError('add_account_form', trans('Different Password'));
        }
        elseif (find($this->oHttpRequest->post('password1'), $this->oHttpRequest->post('name')))
        {
            \PFBC\Form::setError('add_account_form', trans('For your security, your password must be different than your name'));
        }
        else
        {

            $aData = [
                'email' => $this->oHttpRequest->post('email'),
                'name' => $this->oHttpRequest->post('name'),
                'password' => Security::hashPwd($this->oHttpRequest->post('password1'))
            ];

            if((new InstallModel)->exe($aData, 'add_user'))
            {
                // Success
                \PFBC\Form::clearValues('add_account_form');
                \PFBC\Form::setSuccess('add_account_form', trans('Your account has been successfully created'));

                redirect('?m=install&a=finish');
            }
            else
            {
                \PFBC\Form::setError('add_account_form', trans('Error occurred'));
            }
        }
    }

}