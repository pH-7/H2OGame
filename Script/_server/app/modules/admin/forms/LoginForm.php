<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class LoginForm
{

    public static function display()
    {
        if (isset($_POST['submit_login']))
        {
            if (\PFBC\Form::isValid($_POST['submit_login']))
                new LoginProcessForm;

            redirect('?m=admin&a=login');
        }

        $oForm = new \PFBC\Form('login_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_login', 'login_form'));
        $oForm->addElement(new \PFBC\Element\Email(trans('Email'), 'email', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Password(trans('Password'), 'password', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Login')));
        $oForm->render();
    }

}