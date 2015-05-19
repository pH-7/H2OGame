<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class PasswordProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $oAdminModel = new AdminModel;

        if (!validate_identical($this->oHttpRequest->post('password1'), $this->oHttpRequest->post('password2')))
        {
            \PFBC\Form::setError('password_form', trans('Different Password'));
        }
        elseif (find($this->oHttpRequest->post('password1'), $this->oSession->get('admin_name')))
        {
            \PFBC\Form::setError('password_form', trans('For your security, your password must be different than your name'));
        }
        elseif (!$oAdminModel->login($this->oSession->get('admin_email'), $this->oHttpRequest->post('old_password')))
        {
             \PFBC\Form::setError('password_form', trans('Current Password is wrong'));
        }
        else
        {
            $aData = array('profile_id' => $this->oSession->get('admin_id'), 'password' => Security::hashPwd($this->oHttpRequest->post('password1')));
            $oAdminModel->exe($aData, 'update_password');

            \PFBC\Form::clearValues('password_form');
            Admin::logout($this->oSession, trans('Password has been changed with success')); // For security reasons, we disconnect the admin
        }
    }

}