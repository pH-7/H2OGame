<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class LoginProcessForm extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $oAdminModel = new AdminModel;

        if ($oAdminModel->login($this->oHttpRequest->post('email'), $this->oHttpRequest->post('password')))
        {
            // OK
            \PFBC\Form::clearValues('login_form');

            $iId = $oAdminModel->getId($this->oHttpRequest->post('email'));
            $oAdminData = $oAdminModel->readProfile($iId);

            // Regenerate the session ID to prevent the session fixation
            $this->oSession->regenerateId();

            $aSessData = [
               'admin_id' => $oAdminData->profileId,
               'admin_email' => $oAdminData->email,
               'admin_name' => $oAdminData->name,
               'admin_ip' => client_ip(),
               'admin_http_user_agent' => user_agent(),
               'admin_token' => Various::genRnd($oAdminData->email),
            ];
            $this->oSession->set($aSessData);

            \PFBC\Form::clearValues('login_form');
            \PFBC\Form::setSuccess('login_form', trans('You have successfully logged in'));

            redirect('?m=admin&a=index');
        }
        else
        {
            \PFBC\Form::setError('login_form', trans('Email or Password is invalid'));
        }
    }

}
