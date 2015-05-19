<?php
/**
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2014-2015, Pierre-Henry Soria. All Rights Reserved.
 * @license          See H2O.LICENSE.txt and H2O.COPYRIGHT.txt in the root directory.
 * @link             http://hizup.com
 */

namespace H2O;
defined('H2O') or exit('Access denied');

class PasswordForm
{

    public static function display()
    {
        if (isset($_POST['submit_password']))
        {
            if (\PFBC\Form::isValid($_POST['submit_password']))
                new PasswordProcessForm;

            redirect('?m=admin&a=password');
        }

        $oForm = new \PFBC\Form('password_form');
        $oForm->configure(array('action' => ''));
        $oForm->addElement(new \PFBC\Element\Hidden('submit_password', 'password_form'));
        $oForm->addElement(new \PFBC\Element\Password(trans('Your current Password'), 'old_password', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Password(trans('Your new Password'), 'password1', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Password(trans('Repeat your new Password'), 'password2', array('required' => 1)));
        $oForm->addElement(new \PFBC\Element\Button(trans('Change')));
        $oForm->render();
    }

}